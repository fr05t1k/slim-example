<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Component\MongoDB;

use Interop\Container\ContainerInterface;
use MongoDB\Client;

/**
 * Class MongodbFactory
 * @package Fr05t1k\SlimExample\Component\MongoDB
 */
class ClientFactory
{
    /**
     * @param ContainerInterface $c
     * @return Client
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \MongoDB\Exception\InvalidArgumentException
     * @throws \MongoDB\Driver\Exception\RuntimeException
     * @throws \MongoDB\Driver\Exception\InvalidArgumentException
     */
    public function create(ContainerInterface $c): Client
    {
        $uri = $c->get('settings.db.dsn');
        $uriOptions = [
            'connectTimeoutMS' => $c->get('settings.db.connectTimeoutMS'),
            'socketTimeoutMS' => $c->get('settings.db.socketTimeoutMS'),
        ];
        return new Client($uri, $uriOptions);
    }
}
