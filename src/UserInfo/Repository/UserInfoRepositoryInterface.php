<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\UserInfo\Repository;

use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;
use Fr05t1k\SlimExample\Repository\Exception\RepositoryException;
use Fr05t1k\SlimExample\Repository\Exception\UserInfoNotFoundException;

/**
 * Interface UserInfoRepositoryInterface
 * @package Fr05t1k\SlimExample\UserInfo
 */
interface UserInfoRepositoryInterface
{
    /**
     * @param $id
     * @return UserInfoInterface
     * @throws RepositoryException
     * @throws UserInfoNotFoundException
     */
    public function getById($id): UserInfoInterface;

    /**
     * @param \Fr05t1k\SlimExample\UserInfo\UserInfoInterface $userInfo
     * @return bool
     * @throws RepositoryException
     */
    public function save(UserInfoInterface $userInfo): bool;
}