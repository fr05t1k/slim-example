<?php declare(strict_types = 1);

use function DI\factory;
use function DI\object;
use Fr05t1k\SlimExample\Component\Http\Response;
use Fr05t1k\SlimExample\Handler\Error\ErrorHandler;
use Fr05t1k\SlimExample\Handler\Error\NotAllowedHandler;
use Fr05t1k\SlimExample\Handler\Error\NotFoundHandler;
use Fr05t1k\SlimExample\Handler\Error\PhpErrorHandler;
use Fr05t1k\SlimExample\Provider\AccessToken\Repository\AccessTokenRepositoryInterface;
use Fr05t1k\SlimExample\Provider\Facebook\FacebookProvider;
use Fr05t1k\SlimExample\Provider\Facebook\Repository\AccessTokenMongoDbRepository;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoMongoDbRepository;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoRepositoryInterface;
use Interop\Container\ContainerInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Slim\Http\Headers;

return [
    'errorHandler' => object(ErrorHandler::class),
    'notAllowedHandler' => object(NotAllowedHandler::class),
    'phpErrorHandler' => object(PhpErrorHandler::class),
    'notFoundHandler' => object(NotFoundHandler::class),

    'response' => function (ContainerInterface $c) {
        $headers = new Headers(['Content-Type' => 'application/json; charset=UTF-8']);
        $response = new Response(200, $headers);
        return $response->withProtocolVersion($c->get('settings')['httpVersion']);
    },

    LoggerInterface::class => factory(function (ContainerInterface $c) {
        $appName = $c->get('settings.app.name');

        $logsPath = $c->get('settings.logs.path');
        $logsPath = rtrim($logsPath, '/') . '/';

        $logger = new Logger($appName);

        if ($c->get('settings.logs.debug.enabled')) {
            $logger->pushHandler(
                (new StreamHandler($logsPath . $appName . '.debug.log', Logger::DEBUG))
                    ->setFormatter(new LineFormatter(null, 'Y-m-d H:i:s.u', true, true))
            );
        }

        $logger->pushHandler(
            (new StreamHandler($logsPath . $appName . '.log', Logger::INFO, false))
                ->setFormatter(new LineFormatter(null, null, true, true))
        );

        $logger->pushHandler(
            (new StreamHandler($logsPath . $appName . '.error.log', Logger::ERROR, false))
                ->setFormatter(new LineFormatter(null, null, true, true))
        );

        return $logger;
    }),

    \MongoDB\Client::class => factory(function (ContainerInterface $c) {
        $uri = $c->get('settings.db.dsn');
        $uriOptions = [
            'connectTimeoutMS' => $c->get('settings.db.connectTimeoutMS'),
            'socketTimeoutMS' => $c->get('settings.db.socketTimeoutMS'),
        ];
        return new \MongoDB\Client($uri, $uriOptions);
    }),

    \MongoDB\Database::class => factory(function (\MongoDB\Client $client, ContainerInterface $container) {
        return $client->selectDatabase($container->get('settings.db.name'));
    }),

    UserInfoRepositoryInterface::class => factory(function (\MongoDB\Database $database, LoggerInterface $logger) {
        $repo = new UserInfoMongoDbRepository($database);
        $repo->setLogger($logger);
        return $repo;
    }),
    AccessTokenRepositoryInterface::class => factory(function (\MongoDB\Database $database, LoggerInterface $logger) {
        $repo = new AccessTokenMongoDbRepository($database);
        $repo->setLogger($logger);
        return $repo;
    }),

    ProviderInterface::class => factory(function (ContainerInterface $c) {
        $facebookClient = new Facebook\Facebook([
            'app_id' => $c->get('settings.providers.facebook.appId'),
            'app_secret' => $c->get('settings.providers.facebook.secret'),
        ]);
        return new FacebookProvider($facebookClient);
    })
];
