<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\AccessToken;

interface AccessTokenInterface
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
    public function getValue(): string;

    /**
     * @param string $token
     * @return $this
     */
    public function setValue(string $token);
}