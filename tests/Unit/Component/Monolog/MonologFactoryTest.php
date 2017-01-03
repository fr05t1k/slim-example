<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Component\Monolog;

use Fr05t1k\SlimExampleTests\Component\MockableContainer;
use Mockery as m;

use Fr05t1k\SlimExample\Component\Monolog\MonologFactory;
use Monolog\Logger;

/**
 * Class MonologFactoryTest
 * @package Fr05t1k\SlimExampleTests\Unit\Component\Monolog
 */
class MonologFactoryTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use MockableContainer;

    public function testCreate()
    {
        $f = new MonologFactory();
        $c = $this->getContainerMock();
        $c->shouldReceive('get')->with('settings.app.name')->andReturn('test.app');
        $c->shouldReceive('get')->with('settings.logs.path')->andReturn('/var/logs');
        $c->shouldReceive('get')->with('settings.logs.debug.enabled')->andReturn(true);

        $l = $f->create($c);
        self::assertInstanceOf(Logger::class, $l);
    }
}
