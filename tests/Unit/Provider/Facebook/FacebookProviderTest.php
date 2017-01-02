<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Provider\Facebook;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphUser;
use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Fr05t1k\SlimExample\Provider\Facebook\FacebookProvider;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;
use Mockery as m;

/**
 * Class FacebookProviderTest
 * @package Fr05t1k\SlimExampleTests\Unit\UserInfo\Provider\Facebook
 */
class FacebookProviderTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testGetUserInfo()
    {
        $lastName = 'Ivanov';
        $firstName = 'Petr';
        $email = 'petr@ivanov.com';
        $birthday = new \DateTime('1985-10-21');
        $id = (string)random_int(100000000, 900000000);
        /** @var m\Mock|GraphUser $graphUser */
        $graphUser = $this->getGraphUser($id, $lastName, $firstName, $email, $birthday);
        /** @var m\Mock|Facebook $facebookClient */
        $facebookClient = m::mock(Facebook::class);
        $facebookClient->shouldReceive('setDefaultAccessToken');
        $facebookClient->shouldReceive('get->getGraphUser')->andReturn($graphUser);
        /** @var m\Mock|\Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface $accessToken */
        $accessToken = m::mock(AccessTokenInterface::class);
        $accessToken->shouldReceive('getValue')->andReturn(bin2hex(random_bytes(20)));

        $provider = new FacebookProvider($facebookClient);
        $useInfo = $provider->getUserInfo($accessToken);
        self::assertInstanceOf(UserInfoInterface::class, $useInfo);
        self::assertEquals($firstName, $useInfo->getFirstName());
        self::assertEquals($lastName, $useInfo->getLastName());
        self::assertEquals($email, $useInfo->getEmail());
        self::assertEquals($birthday, $useInfo->getBirthday());
        self::assertEquals($id, $useInfo->getId());
    }

    /**
     * @expectedException \Fr05t1k\SlimExample\Provider\Exception\ProviderException
     */
    public function testGetUserInfoWithException()
    {
        /** @var m\Mock|Facebook $facebookClient */
        $facebookClient = m::mock(Facebook::class);
        $facebookClient->shouldReceive('setDefaultAccessToken');
        $facebookClient->shouldReceive('get')->andThrow(new FacebookSDKException);
        /** @var m\Mock|\Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface $accessToken */
        $accessToken = m::mock(AccessTokenInterface::class);
        $accessToken->shouldReceive('getValue')->andReturn(bin2hex(random_bytes(20)));

        $provider = new FacebookProvider($facebookClient);
        $provider->getUserInfo($accessToken);
    }

    public function testCreateToken()
    {
        /** @var m\Mock|Facebook $facebookClient */
        $facebookClient = m::mock(Facebook::class);
        $provider = new FacebookProvider($facebookClient);
        $token = $provider->createToken('a');
        self::assertInstanceOf(AccessTokenInterface::class, $token);
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * @param string $id
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     * @param \DateTime $birthday
     * @return GraphUser|m\Mock
     */
    private function getGraphUser(string $id, string $lastName, string $firstName, string $email, \DateTime $birthday)
    {
        /** @var m\Mock|GraphUser $graphUser */
        $graphUser = m::mock(GraphUser::class);
        $graphUser->shouldReceive('getFirstName')->andReturn($firstName);
        $graphUser->shouldReceive('getLastName')->andReturn($lastName);
        $graphUser->shouldReceive('getEmail')->andReturn($email);
        $graphUser->shouldReceive('getBirthday')->andReturn($birthday);
        $graphUser->shouldReceive('getId')->andReturn($id);
        return $graphUser;
    }
}
