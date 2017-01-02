<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\UserInfo\Repository\Hydrator;

use Fr05t1k\SlimExample\Component\MongoDB\DateConverter;
use Fr05t1k\SlimExample\UserInfo\UserInfo;
use Fr05t1k\SlimExample\UserInfo\Repository\Hydrator\UserInfoHydrator;
use MongoDB\BSON\ObjectID;

class UserInfoHydratorTest extends \PHPUnit_Framework_TestCase
{


    public function testExtract()
    {
        $userInfo = new UserInfo('Petrov', 'Ivan', 'ivan@petrov.com');
        $h = new UserInfoHydrator();
        $data = $h->extract($userInfo);

        self::assertEquals('Petrov', $data['lastName']);
        self::assertEquals('Ivan', $data['firstName']);
        self::assertEquals('ivan@petrov.com', $data['email']);
        self::assertEquals(null, $data['birthday']);
        self::assertEquals(null, $data['birthday']);
        $birthday = new \DateTime('1999-10-25');
        $userInfo->setBirthday($birthday);

        $data = $h->extract($userInfo);
        self::assertEquals(DateConverter::fromDateTimeToUTCDateTime($birthday), $data['birthday']);
    }

    public function testHydrate()
    {
        $h = new UserInfoHydrator();
        $userInfo = new UserInfo();
        $objectId = new ObjectID();
        $birthday = new \DateTime('1999-01-25');
        $h->hydrate([
            '_id' => $objectId,
            'firstName' => 'Ivan',
            'lastName' => 'Petrov',
            'email' => 'ivan@petrov.com',
            'birthday' => DateConverter::fromDateTimeToUTCDateTime($birthday),
        ], $userInfo);

        self::assertEquals('Ivan', $userInfo->getFirstName());
        self::assertEquals('Petrov', $userInfo->getLastName());
        self::assertEquals('ivan@petrov.com', $userInfo->getEmail());
        self::assertEquals($birthday, $userInfo->getBirthday());
        self::assertEquals($objectId, $userInfo->getId());
    }
}
