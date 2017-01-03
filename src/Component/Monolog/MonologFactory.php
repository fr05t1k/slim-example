<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Component\Monolog;

use Interop\Container\ContainerInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class MonologFactory
 * @package Fr05t1k\SlimExample\Component\Monolog
 */
class MonologFactory
{
    /**
     * @param ContainerInterface $c
     * @return Logger
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function create(ContainerInterface $c): Logger
    {
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
    }
}
