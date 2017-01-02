<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Repository\Exception;

/**
 * Class RepositoryException
 * @package Fr05t1k\SlimExample\Repository\Exception
 */
class RepositoryException extends \Exception
{

    /**
     * RepositoryException constructor.
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('', 0, $previous);
    }
}
