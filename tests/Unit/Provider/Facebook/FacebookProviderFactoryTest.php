<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Provider\Facebook;

use Fr05t1k\SlimExample\Provider\Facebook\FacebookProvider;
use Fr05t1k\SlimExampleTests\Component\MockableContainer;
use Mockery as m;

use Fr05t1k\SlimExample\Provider\Facebook\FacebookProviderFactory;

/**
 * Class FacebookProviderFactoryTest
 * @package Fr05t1k\SlimExampleTests\Unit\Provider\Facebook
 */
class FacebookProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use MockableContainer;

    public function testCreate()
    {
        $f = new FacebookProviderFactory();
        $c = $this->getContainerMock();
        $c->shouldReceive('get')->with('settings.providers.facebook.appId')->andReturn(bin2hex(random_bytes(20)));
        $c->shouldReceive('get')->with('settings.providers.facebook.secret')->andReturn(bin2hex(random_bytes(20)));
        $p = $f->create($c);

        self::assertInstanceOf(FacebookProvider::class, $p);
    }
}
