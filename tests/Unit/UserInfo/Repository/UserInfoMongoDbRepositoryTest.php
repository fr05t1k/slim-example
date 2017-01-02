<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\UserInfo\Repository;

use Fr05t1k\SlimExample\UserInfo\UserInfo;
use Fr05t1k\SlimExample\UserInfo\Repository\Hydrator\UserInfoHydrator;
use Fr05t1k\SlimExample\UserInfo\Repository\UserInfoMongoDbRepository;
use Mockery as m;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
use MongoDB\Database;

/**
 * Class UserInfoMongoDbRepositoryTest
 * @package Fr05t1k\SlimExampleTests\Unit\Repository
 */
class UserInfoMongoDbRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testGetById()
    {
        $birthday = new \DateTime('1984-12-28', new \DateTimeZone('UTC'));
        /** @var Collection|m\Mock $collection */
        $collection = m::mock(Collection::class);
        $objectId = new ObjectID();
        $objectIdString = (string)$objectId;
        $collection->shouldReceive('findOne')
            ->with(['_id' => $objectIdString])
            ->andReturn([
                '_id' => $objectId,
                'firstName' => 'Ivan',
                'lastName' => 'Petrov',
                'birthday' => new UTCDateTime($birthday->getTimestamp() * 1000),
                'email' => 'ivan@petrov.com',
            ]);

        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new UserInfoMongoDbRepository($database, new UserInfoHydrator);
        $userInfo = $repo->getById($objectIdString);

        self::assertEquals('Ivan', $userInfo->getFirstName());
        self::assertEquals('Petrov', $userInfo->getLastName());
        self::assertEquals('ivan@petrov.com', $userInfo->getEmail());
        self::assertEquals($birthday, $userInfo->getBirthday());
    }

    /**
     * @expectedException \Fr05t1k\SlimExample\Repository\Exception\UserInfoNotFoundException
     */
    public function testGetByIdWithEmptyData()
    {
        /** @var Collection|m\Mock $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('findOne')
            ->andReturn(null);

        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new UserInfoMongoDbRepository($database, new UserInfoHydrator);
        $repo->getById('abc');
    }

    /**
     * @expectedException \Fr05t1k\SlimExample\Repository\Exception\RepositoryException
     */
    public function testGetByIdWithException()
    {
        /** @var Collection|m\Mock $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('findOne')
            ->andThrow(new \RuntimeException());

        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new UserInfoMongoDbRepository($database, new UserInfoHydrator);
        $repo->getById('abc');
    }

    public function testSave()
    {
        /** @var m\Mock|Collection $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('updateOne');


        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new UserInfoMongoDbRepository($database, new UserInfoHydrator());

        self::assertTrue($repo->save(new UserInfo()));
    }

    public function testSaveWithException()
    {
        /** @var m\Mock|Collection $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('updateOne')->andThrow(new \RuntimeException());


        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new UserInfoMongoDbRepository(
            $database,
            new UserInfoHydrator()
        );

        self::assertFalse($repo->save(new UserInfo()));
    }


}
