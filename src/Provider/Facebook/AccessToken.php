<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\Facebook;

use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;

/**
 * Class AccessToken
 * @package Fr05t1k\SlimExample\UserInfo\Provider\Facebook
 */
class AccessToken extends \Facebook\Authentication\AccessToken implements AccessTokenInterface
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * AccessToken constructor.
     * @param string $accessToken
     * @param int $expiresAt
     */
    public function __construct($accessToken = '', $expiresAt = 0)
    {
        parent::__construct($accessToken, $expiresAt);
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
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
    public function getValue(): string
    {
        return parent::getValue();
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setValue(string $token)
    {
        $this->value = $token;
        return $this;
    }
}
