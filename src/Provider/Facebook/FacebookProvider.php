<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\Facebook;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Fr05t1k\SlimExample\Provider\Exception\ProviderException;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Fr05t1k\SlimExample\UserInfo\UserInfo;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;

/**
 * Class FacebookProvider
 * @package Fr05t1k\SlimExample\UserInfo\Provider\Facebook
 */
class FacebookProvider implements ProviderInterface
{
    /**
     * @var Facebook
     */
    private $facebookClient;

    /**
     * FacebookProvider constructor.
     * @param $facebookClient
     */
    public function __construct(Facebook $facebookClient)
    {
        $this->facebookClient = $facebookClient;
    }

    /**
     * @param AccessTokenInterface $accessToken
     * @return UserInfoInterface
     * @throws \Fr05t1k\SlimExample\Provider\Exception\ProviderException
     */
    public function getUserInfo(AccessTokenInterface $accessToken): UserInfoInterface
    {
        try {
            $this->facebookClient->setDefaultAccessToken($accessToken->getValue());
            $response = $this->facebookClient->get('me?fields=' . implode(',', $this->getRequiredFields()));
            $userGraph = $response->getGraphUser();
        } catch (FacebookSDKException|\InvalidArgumentException $e) {
            throw new ProviderException($e);
        }

        $userInfo = new UserInfo($userGraph->getLastName(), $userGraph->getFirstName(), $userGraph->getEmail());
        $userInfo->setId($userGraph->getId());
        $userInfo->setBirthday($userGraph->getBirthday());
        return $userInfo;
    }

    /**
     * @return array
     */
    private function getRequiredFields(): array
    {
        return [
            'email',
            'first_name',
            'last_name',
            'birthday',
        ];
    }

    /**
     * @param $token
     * @return \Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface
     */
    public function createToken($token): AccessTokenInterface
    {
        return new AccessToken($token);
    }
}
