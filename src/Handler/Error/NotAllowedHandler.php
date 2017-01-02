<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Handler\Error;

use Fr05t1k\SlimExample\Component\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class NotAllowedHandler
 *
 * @package Fr05t1k\SlimExample\Handler\Error
 */
class NotAllowedHandler
{
    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param array $methods
     *
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function __invoke(ServerRequestInterface $request, Response $response, array $methods)
    {

        return $response->withError('Method not allowed.', Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
