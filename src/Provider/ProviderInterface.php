<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider;

use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;

/**
 * Interface ProviderInterface
 * @package Fr05t1k\SlimExample\UserInfo\Provider
 */
interface ProviderInterface
{
    /**
     * @param \Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface $accessToken
     * @return UserInfoInterface
     * @throws \Fr05t1k\SlimExample\Provider\Exception\ProviderException
     */
    public function getUserInfo(AccessTokenInterface $accessToken): UserInfoInterface;

    public function createToken($token): AccessToken\AccessTokenInterface;
}
