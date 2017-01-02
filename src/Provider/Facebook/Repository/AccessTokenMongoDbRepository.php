<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\Facebook\Repository;

use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Fr05t1k\SlimExample\Provider\AccessToken\Repository\AccessTokenRepositoryInterface;
use Fr05t1k\SlimExample\Provider\AccessToken\Repository\Exception\AccessTokenNotFoundException;
use Fr05t1k\SlimExample\Provider\Facebook\AccessToken;
use Fr05t1k\SlimExample\Provider\Facebook\Repository\Hydrator\AccessTokenHydrator;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use InvalidArgumentException;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Exception\BadMethodCallException;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Zend\Hydrator\HydratorAwareTrait;

/**
 * Class AccessTokenMongoDbRepository
 * @package Fr05t1k\SlimExample\Provider\Facebook\Repository
 */
class AccessTokenMongoDbRepository implements AccessTokenRepositoryInterface
{
    use LoggerAwareTrait;
    use HydratorAwareTrait;

    const COLLECTION_NAME = 'AccessToken';
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
        $this->hydrator = new AccessTokenHydrator();
        $this->setLogger(new NullLogger());
    }

    /**
     * @param $id
     * @return AccessTokenInterface
     * @throws AccessTokenNotFoundException
     * @throws RepositoryException
     */
    public function getById($id): AccessTokenInterface
    {
        try {
            $data = $this->collection->findOne(['_id' => $id]);
            if ($data === null) {
                throw new AccessTokenNotFoundException();
            }
            $accessToken = new AccessToken();
            $this->hydrator->hydrate($data, $accessToken);
            return $accessToken;
        } catch (BadMethodCallException|\RuntimeException|InvalidArgumentException $e) {
            $this->logger->error('Can not find AccessToken', ['exception' => $e]);
            throw new RepositoryException($e);
        }
    }

    /**
     * @param AccessTokenInterface $token
     * @return bool
     */
    public function save(AccessTokenInterface $token): bool
    {
        try {
            $this->collection->updateOne(
                ['_id' => $token->getId()],
                ['$set' => $this->hydrator->extract($token)],
                ['upsert' => true]
            );
            return true;
        } catch (BadMethodCallException|\RuntimeException|InvalidArgumentException $e) {
            $this->logger->error('Can not save AccessToken', ['exception' => $e]);
            return false;
        }
    }
}