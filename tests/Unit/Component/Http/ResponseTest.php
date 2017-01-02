<?php


namespace Fr05t1k\SlimExampleTests\Unit\Component\Http;


use Fr05t1k\SlimExample\Component\Http\Response;
use Fr05t1k\SlimExample\Component\Entity\Entity;
use Mockery as m;

/**
 * Class ResponseTest
 * @package Fr05t1k\SlimExampleTests\Unit\Component\Http
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testWithResponseForEntity()
    {
        /** @var m\Mock|Entity $entity */
        $entity = m::mock(Entity::class);
        $entity->shouldReceive('getHydrator->extract')->andReturn([
            'id' => 1,
            'name' => 'Test name',
        ]);

        $response = new Response();
        $response = $response->withResponseForEntity($entity);
        $response->getBody()->rewind();
        $data = json_decode($response->getBody()->getContents(), true);

        $entityResponse = $data['data'];

        static::assertEquals(1, $entityResponse['id']);
        static::assertEquals('Test name', $entityResponse['name']);
    }
}

