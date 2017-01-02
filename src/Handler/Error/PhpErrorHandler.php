<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Handler\Error;

use Fr05t1k\SlimExample\Component\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Class PhpErrorHandler
 *
 * @package Fr05t1k\SlimExample\Handler\Error
 */
class PhpErrorHandler
{
    use LoggerAwareTrait;
    const PHP_ERROR_MESSAGE = 'Internal Server Error';

    /**
     * PhpErrorHandler constructor.
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
     * @param \Throwable $error
     *
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function __invoke(ServerRequestInterface $request, Response $response, \Throwable $error)
    {
        $message = sprintf(
            '%s:%s %s %s',
            $error->getFile(),
            $error->getLine(),
            $error->getMessage(),
            $error->getTraceAsString()
        );
        if (getenv('SLIM_EXAMPLE_DISPLAY_ERRORS')) {
            return $response->withError($message, Response::HTTP_INTERNAL_SERVER_ERROR, $error->getCode());
        } else {
            $this->logger->info($message);
            return $response->withError(static::PHP_ERROR_MESSAGE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
