<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Component\Http;

use Interop\Container\ContainerInterface;
use Slim\Http\Headers;

/**
 * Class ResponseFactory
 * @package Fr05t1k\SlimExample\Component\Http
 */
class ResponseFactory
{

    /**
     * @param ContainerInterface $c
     * @return Response
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \InvalidArgumentException
     */
    public function create(ContainerInterface $c): Response
    {
        $headers = new Headers(['Content-Type' => 'application/json; charset=UTF-8']);
        $response = new Response(200, $headers);
        return $response->withProtocolVersion($c->get('settings')['httpVersion']);
    }
}
