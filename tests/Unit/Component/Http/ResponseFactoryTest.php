<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Component\Http;

use Fr05t1k\SlimExample\Component\Http\Response;
use Fr05t1k\SlimExample\Component\Http\ResponseFactory;
use Fr05t1k\SlimExampleTests\Component\MockableContainer;
use Mockery as m;

/**
 * Class ResponseFactoryTest
 * @package Fr05t1k\SlimExampleTests\Unit\Component\Http
 */
class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use MockableContainer;

    public function testCreate()
    {
        $factory = new ResponseFactory();
        $container = $this->getContainerMock();
        $container->shouldReceive('get')->with('settings')->andReturn(['httpVersion' => '1.1']);
        $response = $factory->create($container);

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals('1.1', $response->getProtocolVersion());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
