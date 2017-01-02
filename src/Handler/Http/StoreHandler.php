<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Handler\Http;

use Fr05t1k\SlimExample\Component\Http\Response;
use Fr05t1k\SlimExample\Component\Entity\Entity;
use Fr05t1k\SlimExample\Handler\Common\StoreHandler as CommonStoreHandler;
use Fr05t1k\SlimExample\Provider\Exception\ProviderException;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use Slim\Http\Request;

/**
 * Class StoreHandler
 */
class StoreHandler
{
    /**
     * @var CommonStoreHandler
     */
    private $handler;

    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * StoreHandler constructor.
     * @param CommonStoreHandler $handler
     * @param ProviderInterface $provider
     */
    public function __construct(CommonStoreHandler $handler, ProviderInterface $provider)
    {
        $this->handler = $handler;
        $this->provider = $provider;
    }


    public function __invoke(Request $request, Response $response)
    {
        $tokenString = $request->getParam('token');

        if ($tokenString === null || $tokenString === '') {
            return $response->withError('Please specify token parameter');
        }
        $token = $this->provider->createToken($tokenString);

        $h = $this->handler;

        try {
            $userInfo = $h($token);
        } catch (ProviderException $e) {
            return $response->withError('Can not retrieve information by this token');
        } catch (RepositoryException $e) {
            return $response->withError('Can not save information by this token');
        }

        if ($userInfo instanceof Entity) {
            return $response->withResponseForEntity($userInfo);
        } else {
            return $response->withSuccess($userInfo);
        }
    }
}
