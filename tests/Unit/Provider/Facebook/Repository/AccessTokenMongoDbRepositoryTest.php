<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Provider\Facebook\Repository;

use Fr05t1k\SlimExample\Provider\Facebook\AccessToken;
use Fr05t1k\SlimExample\Provider\Facebook\Repository\AccessTokenMongoDbRepository;
use Mockery as m;
use MongoDB\Collection;
use MongoDB\Database;

/**
 * Class AccessTokenMongoDbRepositoryTest
 * @package Fr05t1k\SlimExampleTests\Unit\Provider\Facebook\Repository
 */
class AccessTokenMongoDbRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testGetById()
    {
        /** @var Collection|m\Mock $collection */
        $collection = m::mock(Collection::class);
        $objectId = '123456789';
        $value = 'abc12345abc';
        $collection->shouldReceive('findOne')
            ->with(['_id' => $objectId])
            ->andReturn([
                '_id' => $objectId,
                'value' => $value,
            ]);

        $database = $this->getDatabaseWithCollection($collection);

        $repo = new AccessTokenMongoDbRepository($database);
        $token = $repo->getById($objectId);

        self::assertEquals($value, $token->getValue());
        self::assertEquals($objectId, $token->getId());
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

        $database = $this->getDatabaseWithCollection($collection);

        $repo = new AccessTokenMongoDbRepository($database);
        $repo->getById('');
    }

    /**
     * @expectedException \Fr05t1k\SlimExample\Provider\AccessToken\Repository\Exception\AccessTokenNotFoundException
     */
    public function testGetByIdWithEmptyData()
    {
        /** @var Collection|m\Mock $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('findOne')
            ->andReturn(null);

        $database = $this->getDatabaseWithCollection($collection);

        $repo = new AccessTokenMongoDbRepository($database);
        $repo->getById('');
    }


    public function testSave()
    {
        /** @var m\Mock|Collection $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('updateOne');


        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new AccessTokenMongoDbRepository($database);

        self::assertTrue($repo->save(new AccessToken()));
    }

    public function testSaveWithException()
    {
        /** @var m\Mock|Collection $collection */
        $collection = m::mock(Collection::class);
        $collection->shouldReceive('updateOne')->andThrow(new \RuntimeException());


        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);

        $repo = new AccessTokenMongoDbRepository(
            $database
        );

        self::assertFalse($repo->save(new AccessToken()));
    }

    /**
     * @param Collection $collection
     * @return m\Mock|Database
     */
    private function getDatabaseWithCollection(Collection $collection)
    {
        /** @var Database|m\Mock $database */
        $database = m::mock(Database::class);
        $database->shouldReceive('selectCollection')->andReturn($collection);
        return $database;
    }
}
