<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Component;

use Interop\Container\ContainerInterface;
use Mockery as m;

/**
 * Class MockableContainer
 * @package Fr05t1k\SlimExampleTests\Component
 */
trait MockableContainer
{
    /**
     * @return m\Mock|ContainerInterface
     */
    public function getContainerMock()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return m::mock(ContainerInterface::class);
    }
}
