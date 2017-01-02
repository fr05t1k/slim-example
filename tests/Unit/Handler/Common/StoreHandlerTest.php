<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Handler\Common;

use Fr05t1k\SlimExample\Provider\AccessToken\Repository\AccessTokenRepositoryInterface;
use Fr05t1k\SlimExample\UserInfo\UserInfo;
use Fr05t1k\SlimExample\Handler\Common\StoreHandler;
use Fr05t1k\SlimExample\Provider\Exception\ProviderException;
use Fr05t1k\SlimExample\Provider\Facebook\AccessToken;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoRepositoryInterface;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;
use Mockery as m;

/**
 * Class StoreHandlerTest
 * @package Fr05t1k\SlimExampleTests\Handler\Http
 */
class StoreHandlerTest extends \PHPUnit_Framework_TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testInvoke()
    {
        /** @var m\Mock|UserInfoRepositoryInterface $userInfoRepo */
        $userInfoRepo = m::mock(UserInfoRepositoryInterface::class);
        $userInfoRepo->shouldReceive('save')->andReturn(true);
        /** @var m\Mock|AccessTokenRepositoryInterface $accessTokenRepo */
        $accessTokenRepo = m::mock(AccessTokenRepositoryInterface::class);
        $accessTokenRepo->shouldReceive('save')->andReturn(true);
        /** @var m\Mock|ProviderInterface $provider */
        $provider = m::mock(ProviderInterface::class);
        $provider->shouldReceive('getUserInfo')->andReturn(new UserInfo());
        $h = new StoreHandler(
            $userInfoRepo,
            $accessTokenRepo,
            $provider
        );

        $userInfo = $h(new AccessToken('a'));
        self::assertInstanceOf(UserInfoInterface::class, $userInfo);
    }

    /**
     * @expectedException \Fr05t1k\SlimExample\Provider\Exception\ProviderException
     */
    public function testInvokeWithExceptionFromProvider()
    {
        /** @var m\Mock|\Fr05t1k\SlimExample\UserInfo\Repository\UserInfoRepositoryInterface $repo */
        $repo = m::mock(UserInfoRepositoryInterface::class);
        /** @var m\Mock|AccessTokenRepositoryInterface $accessTokenRepo */
        $accessTokenRepo = m::mock(AccessTokenRepositoryInterface::class);
        /** @var m\Mock|ProviderInterface $provider */
        $provider = m::mock(ProviderInterface::class);
        $provider->shouldReceive('createToken')->with('a')->andReturn(new AccessToken('a'));
        $provider->shouldReceive('getUserInfo')->andThrow(new ProviderException());
        $h = new StoreHandler(
            $repo,
            $accessTokenRepo,
            $provider
        );

        $h(new AccessToken('a'));
    }

    /**
     * @expectedException \Fr05t1k\SlimExample\Repository\Exception\RepositoryException
     */
    public function testInvokeWithExceptionFromRepo()
    {
        /** @var m\Mock|UserInfoRepositoryInterface $repo */
        $repo = m::mock(UserInfoRepositoryInterface::class);
        $repo->shouldReceive('save')->andThrow(new RepositoryException());
        /** @var m\Mock|AccessTokenRepositoryInterface $accessTokenRepo */
        $accessTokenRepo = m::mock(AccessTokenRepositoryInterface::class);
        /** @var m\Mock|ProviderInterface $provider */
        $provider = m::mock(ProviderInterface::class);
        $provider->shouldReceive('createToken')->with('a')->andReturn(new AccessToken('a'));
        $provider->shouldReceive('getUserInfo')->andReturn(new UserInfo());
        $h = new StoreHandler(
            $repo,
            $accessTokenRepo,
            $provider
        );

        $h(new AccessToken('a'));
    }
}
