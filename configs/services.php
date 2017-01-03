<?php declare(strict_types = 1);

use function DI\factory;
use function DI\object;
use Fr05t1k\SlimExample\Component\Http\ResponseFactory;
use Fr05t1k\SlimExample\Component\MongoDB\ClientFactory;
use Fr05t1k\SlimExample\Component\Monolog\MonologFactory;
use Fr05t1k\SlimExample\Handler\Error\ErrorHandler;
use Fr05t1k\SlimExample\Handler\Error\NotAllowedHandler;
use Fr05t1k\SlimExample\Handler\Error\NotFoundHandler;
use Fr05t1k\SlimExample\Handler\Error\PhpErrorHandler;
use Fr05t1k\SlimExample\Provider\AccessToken\Repository\AccessTokenRepositoryInterface;
use Fr05t1k\SlimExample\Provider\Facebook\FacebookProviderFactory;
use Fr05t1k\SlimExample\Provider\Facebook\Repository\AccessTokenMongoDbRepository;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoMongoDbRepository;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoRepositoryInterface;
use Interop\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    'errorHandler' => object(ErrorHandler::class),
    'notAllowedHandler' => object(NotAllowedHandler::class),
    'phpErrorHandler' => object(PhpErrorHandler::class),
    'notFoundHandler' => object(NotFoundHandler::class),
    'response' => factory([new ResponseFactory(), 'create']),

    LoggerInterface::class => factory([new MonologFactory, 'create']),

    \MongoDB\Client::class => factory([new ClientFactory(), 'create']),

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

    ProviderInterface::class => factory([new FacebookProviderFactory(), 'create'])
];
