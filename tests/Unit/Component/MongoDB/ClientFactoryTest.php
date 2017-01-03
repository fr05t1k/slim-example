<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Component\MongoDB;

use Fr05t1k\SlimExample\Component\MongoDB\ClientFactory;
use Fr05t1k\SlimExampleTests\Component\MockableContainer;
use Mockery as m;
use MongoDB\Client;

/**
 * Class ClientFactoryTest
 * @package Fr05t1k\SlimExampleTests\Unit\Component\MongoDB
 */
class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use MockableContainer;

    public function testCreate()
    {
        $f = new ClientFactory();
        $c = $this->getContainerMock();
        $c->shouldReceive('get')->with('settings.db.dsn')->andReturn('mongodb://localhost');
        $c->shouldReceive('get')->with('settings.db.connectTimeoutMS')->andReturn(300);
        $c->shouldReceive('get')->with('settings.db.socketTimeoutMS')->andReturn(10000);

        $c = $f->create($c);

        self::assertInstanceOf(Client::class, $c);
    }
}
