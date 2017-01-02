<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\UserInfo;

/**
 * Interface UserInfoInterface
 * @package Fr05t1k\SlimExample\Entity
 */
interface UserInfoInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName);

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName);

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * @return \DateTime|null
     */
    public function getBirthday();

    /**
     * @param \DateTime $birthday
     * @return $this
     */
    public function setBirthday(\DateTime $birthday);
}
