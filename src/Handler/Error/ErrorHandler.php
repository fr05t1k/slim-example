<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Handler\Error;

use Fr05t1k\SlimExample\Component\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Class ErrorHandler
 *
 * @package Fr05t1k\SlimExample\Handler\Error
 */
class ErrorHandler
{
    use LoggerAwareTrait;

    /**
     * ErrorHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param \Exception $exception
     *
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function __invoke(ServerRequestInterface $request, Response $response, \Exception $exception)
    {
        $message = $exception->getMessage();
        $this->logger->info($message, ['request' => $request]);

        if (getenv('SLIM_EXAMPLE_DISPLAY_ERRORS')) {
            return $response->withError($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            return $response->withError('Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
