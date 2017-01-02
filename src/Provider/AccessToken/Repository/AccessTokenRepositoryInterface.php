<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\AccessToken\Repository;

use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Fr05t1k\SlimExample\Provider\AccessToken\Repository\Exception\AccessTokenNotFoundException;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;

/**
 * Interface AccessTokenMongoDbRepository
 * @package Fr05t1k\SlimExample\Provider\AccessToken\Repository
 */
interface AccessTokenRepositoryInterface
{
    /**
     * @param $id
     * @return AccessTokenInterface
     * @throws AccessTokenNotFoundException
     * @throws RepositoryException
     */
    public function getById($id): AccessTokenInterface;

    /**
     * @param AccessTokenInterface $token
     * @return bool
     * @throws RepositoryException
     */
    public function save(AccessTokenInterface $token): bool;
}