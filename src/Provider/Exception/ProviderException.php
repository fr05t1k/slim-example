<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\Exception;

/**
 * Base exception for provider's exceptions
 *
 * Class ProviderException
 * @package Fr05t1k\SlimExample\UserInfo\Provider\Exception
 */
class ProviderException extends \Exception
{

    /**
     * ProviderException constructor.
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('Provider exception', 0, $previous);
    }
}