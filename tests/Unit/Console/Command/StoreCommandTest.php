<?php


namespace Fr05t1k\SlimExampleTests\Unit\Console\Command;


use Fr05t1k\SlimExample\Console\Command\StoreCommand;
use Fr05t1k\SlimExample\Handler\Common\StoreHandler;
use Fr05t1k\SlimExample\Provider\Facebook\AccessToken;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Interop\Container\ContainerInterface;
use Mockery as m;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class StoreCommandTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testRun()
    {
        /** @var m\Mock|ContainerInterface $container */
        $container = m::mock(ContainerInterface::class);
        $container->shouldReceive('get')
            ->with(StoreHandler::class)
            ->andReturn(function () {
            });
        /** @var m\Mock|ProviderInterface $provider */
        $provider = m::mock(ProviderInterface::class);
        $provider->shouldReceive('createToken')->andReturn(new AccessToken());
        $container->shouldReceive('get')
            ->with(ProviderInterface::class)
            ->andReturn($provider);
        $command = new StoreCommand($container);

        self::assertEquals(0, $command->run(new ArrayInput(['-t' => 'abc']), new NullOutput()));
    }
}
