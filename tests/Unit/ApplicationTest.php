<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit;

use Fr05t1k\SlimExample\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigureContainer()
    {
        putenv('SLIM_EXAMPLE_DI_CACHE=On');
        putenv('SLIM_EXAMPLE_CACHE_PREFIX=test');
        $app = new Application();

        static::assertInstanceOf(Application::class, $app);
    }
}
