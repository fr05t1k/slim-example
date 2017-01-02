<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\UserInfo\Repository;

use Fr05t1k\SlimExample\UserInfo\UserInfo;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use Fr05t1k\SlimExample\Repository\Exception\UserInfoNotFoundException;
use Fr05t1k\SlimExample\UserInfo\Repository\Hydrator\UserInfoHydrator;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Driver\Exception\InvalidArgumentException;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Zend\Hydrator\Exception\BadMethodCallException;
use Zend\Hydrator\HydratorAwareTrait;

/**
 * Class UserInfoMongoDbRepository
 * @package Fr05t1k\SlimExample\UserInfo
 */
class UserInfoMongoDbRepository implements UserInfoRepositoryInterface
{
    use LoggerAwareTrait;
    use HydratorAwareTrait;

    const COLLECTION_NAME = 'UserInfo';
    /**
     * @var Collection
     */
    private $collection;

    /**
     * UserInfoMongoDbRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $this->collection = $database->selectCollection(self::COLLECTION_NAME);
        $this->hydrator = new UserInfoHydrator();
        $this->setLogger(new NullLogger());
    }

    /**
     * @param $id
     * @return UserInfoInterface
     * @throws RepositoryException
     * @throws UserInfoNotFoundException
     */
    public function getById($id): UserInfoInterface
    {
        try {
            $data = $this->collection->findOne(['_id' => $id]);
            if ($data === null) {
                throw new UserInfoNotFoundException();
            }
            $userInfo = new UserInfo();
            $this->hydrator->hydrate($data, $userInfo);
            return $userInfo;
        } catch (BadMethodCallException|\RuntimeException|InvalidArgumentException $e) {
            $this->logger->error('Can not find UserInfo', ['exception' => $e]);
            throw new RepositoryException($e);
        }
    }

    /**
     * @param UserInfoInterface $userInfo
     * @return bool
     */
    public function save(UserInfoInterface $userInfo): bool
    {
        try {
            $this->collection->updateOne(
                ['_id' => $userInfo->getId()],
                ['$set' => $this->hydrator->extract($userInfo)],
                ['upsert' => true]
            );
            return true;
        } catch (BadMethodCallException|\RuntimeException|InvalidArgumentException $e) {
            $this->logger->error('Can not save UserInfo', ['exception' => $e]);
            return false;
        }
    }
}