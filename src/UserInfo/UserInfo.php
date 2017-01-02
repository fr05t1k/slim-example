<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\UserInfo;

use Fr05t1k\SlimExample\Component\Entity\Entity;
use Fr05t1k\SlimExample\UserInfo\Repository\Hydrator\UserInfoHydrator;
use MongoDB\BSON\ObjectID;

/**
 * Class UserInfo
 * @package Fr05t1k\SlimExample\Entity
 */
class UserInfo extends Entity implements UserInfoInterface
{
    /**
     * @var ObjectID
     */
    private $id;
    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime|null
     */
    private $birthday;

    /**
     * UserInfo constructor.
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     */
    public function __construct(string $lastName = '', string $firstName = '', string $email = '')
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $this->id = new ObjectID();
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->hydrator = new UserInfoHydrator();
    }

    /**
     * @return ObjectID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     * @return $this
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }
}
