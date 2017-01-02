<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Handler\Error;

use Fr05t1k\SlimExample\Component\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class NotFoundHandler
 *
 * @package Fr05t1k\SlimExample\Handler\Error
 */
class NotFoundHandler
{
    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     *
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function __invoke(ServerRequestInterface $request, Response $response)
    {
        return $response->withError('Resource not found', Response::HTTP_NOT_FOUND);
    }
}
