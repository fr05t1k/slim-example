<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Provider\Facebook;

use Fr05t1k\SlimExample\Provider\Facebook\AccessToken;

/**
 * Class AccessTokenTest
 * @package Fr05t1k\SlimExampleTests\Unit\Provider\Facebook
 */
class AccessTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $tokenValue = bin2hex(random_bytes(20));
        $token = new AccessToken($tokenValue);

        static::assertEquals($tokenValue, $token->getValue());
    }
}
