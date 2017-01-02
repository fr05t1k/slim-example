<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\UserInfo;

use Fr05t1k\SlimExample\UserInfo\UserInfo;

/**
 * Class UserInfoTest
 * @package Fr05t1k\SlimExampleTests\Unit\Provider
 */
class UserInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $lastName = 'Ivan';
        $firstName = 'Petrov';
        $email = 'ivan@petrov.com';
        $userInfo = new UserInfo($lastName, $firstName, $email);
        static::assertEquals($firstName, $userInfo->getFirstName());
        static::assertEquals($lastName, $userInfo->getLastName());
        static::assertEquals($email, $userInfo->getEmail());

        $lastName = 'Petr';
        $firstName = 'Ivanov';
        $email = 'petr@ivanov.com';
        static::assertEquals($firstName, $userInfo->setFirstName($firstName)->getFirstName());
        static::assertEquals($lastName, $userInfo->setLastName($lastName)->getLastName());
        static::assertEquals($email, $userInfo->setEmail($email)->getEmail());
    }
}
