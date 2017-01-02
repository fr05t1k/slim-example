<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Handler\Common;


use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Fr05t1k\SlimExample\Provider\AccessToken\Repository\AccessTokenRepositoryInterface;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoRepositoryInterface;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;

/**
 * Class StoreHandler
 * @package Fr05t1k\SlimExample\Handler\Common
 */
class StoreHandler
{
    /**
     * @var  UserInfoRepositoryInterface
     */
    private $userInfoRepository;

    /**
     * @var AccessTokenRepositoryInterface
     */
    private $accessTokenRepository;

    /**
     * @var  ProviderInterface
     */
    private $provider;

    /**
     * StoreHandler constructor.
     * @param UserInfoRepositoryInterface $userInfoRepository
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     * @param ProviderInterface $provider
     */
    public function __construct(
        UserInfoRepositoryInterface $userInfoRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        ProviderInterface $provider
    ) {
        $this->userInfoRepository = $userInfoRepository;
        $this->accessTokenRepository = $accessTokenRepository;
        $this->provider = $provider;
    }


    /**
     * @param AccessTokenInterface $accessToken
     * @return UserInfoInterface
     * @throws \Fr05t1k\SlimExample\Repository\Exception\RepositoryException
     * @throws \Fr05t1k\SlimExample\Provider\Exception\ProviderException
     */
    public function __invoke(AccessTokenInterface $accessToken)
    {
        $userInfo = $this->provider->getUserInfo($accessToken);

        $this->userInfoRepository->save($userInfo);

        $userInfo->setId($userInfo->getId());
        $accessToken->setId($userInfo->getId());

        try {
            $this->accessTokenRepository->save($accessToken);
        } catch (RepositoryException $e) {
        } // not critical

        return $userInfo;
    }
}
