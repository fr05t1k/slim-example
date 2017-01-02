<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Handler\Http;

use Fr05t1k\SlimExample\Component\Http\Response;
use Fr05t1k\SlimExample\Handler\Common\StoreHandler as CommonStoreHandler;
use Fr05t1k\SlimExample\Handler\Http\StoreHandler;
use Fr05t1k\SlimExample\Provider\Exception\ProviderException;
use Fr05t1k\SlimExample\Provider\Facebook\AccessToken;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use Fr05t1k\SlimExample\UserInfo\UserInfo;
use Mockery as m;
use Psr\Http\Message\StreamInterface;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Uri;

/**
 * Class StoreHandlerTest
 * @package Fr05t1k\SlimExampleTests\Unit\Handler\Http
 */
class StoreHandlerTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testInvoke()
    {
        $provider = $this->getProvider();
        $provider->shouldReceive('createToken')->with('a')->andReturn(new AccessToken('a'));

        $commonHandler = $this->getCommonHandler();
        $commonHandler->shouldReceive('__invoke')->andReturn(new UserInfo());
        $h = new StoreHandler(
            $commonHandler,
            $provider
        );

        $response = $h($this->getRequestWithParams(['token' => 'a']), new Response());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testInvokeEmptyToken()
    {
        $provider = $this->getProvider();
        $commonHandler = $this->getCommonHandler();
        $h = new StoreHandler(
            $commonHandler,
            $provider
        );

        $response = $h($this->getRequestWithParams([]), new Response());
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testInvokeWithRepositoryException()
    {
        $provider = $this->getProvider();
        $provider->shouldReceive('createToken')->with('a')->andReturn(new AccessToken('a'));

        $commonHandler = $this->getCommonHandler();
        $commonHandler->shouldReceive('__invoke')->andThrow(new RepositoryException());
        $h = new StoreHandler(
            $commonHandler,
            $provider
        );

        $response = $h($this->getRequestWithParams(['token' => 'a']), new Response());
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testInvokeWithProviderException()
    {
        $provider = $this->getProvider();
        $provider->shouldReceive('createToken')->with('a')->andReturn(new AccessToken('a'));

        $commonHandler = $this->getCommonHandler();
        $commonHandler->shouldReceive('__invoke')->andThrow(new ProviderException());
        $h = new StoreHandler(
            $commonHandler,
            $provider
        );

        $response = $h($this->getRequestWithParams(['token' => 'a']), new Response());
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @return m\Mock|ProviderInterface
     */
    private function getProvider()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return m::mock(ProviderInterface::class);
    }

    /**
     * @return m\Mock|CommonStoreHandler
     */
    private function getCommonHandler()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return m::mock(CommonStoreHandler::class);
    }

    /**
     * @param array $params
     * @return Request
     */
    private function getRequestWithParams(array $params)
    {
        /** @var StreamInterface $stream */
        $stream = m::mock(StreamInterface::class);
        return new Request('post', new Uri(
            'http',
            'localhost',
            8080,
            '/save',
            http_build_query($params)
        ), new Headers(), [], [], $stream);
    }
}
