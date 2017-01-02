<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample;

use DI\Bridge\Slim\App;

/**
 * Class Application
 * @package Fr05t1k\SlimExample
 */
class Application extends App
{
    use ConfigureContainerTrait;
}
