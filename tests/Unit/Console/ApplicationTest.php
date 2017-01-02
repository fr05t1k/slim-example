<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExampleTests\Unit\Console;

use Fr05t1k\SlimExample\Console\Application;
use Symfony\Component\Console\Command\Command;


class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testAddCommandByClassName()
    {
        $app = new Application();
        $app->addCommandByClassName(TestCommand::class);
        $command = $app->get('test');
        static::assertInstanceOf(TestCommand::class, $command);
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\LogicException
     */
    public function testAddCommandByClassNameException()
    {
        $app = new Application();
        $app->addCommandByClassName('stdClass');
    }

    public function testAddCommands()
    {
        $app = new Application();
        $app->addCommands([TestCommand::class]);
        $command = $app->get('test');
        static::assertInstanceOf(TestCommand::class, $command);
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\LogicException
     */
    public function testAddCommandsWithNotExistedClass()
    {
        $app = new Application();
        $app->addCommands(['abc']);
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\LogicException
     */
    public function testAddCommandsWithNotCommandClass()
    {
        $app = new Application();
        $app->addCommands([new \stdClass()]);
    }

    public function testAddCommandsWithInstanceClass()
    {
        $app = new Application();
        $app->addCommands([new TestCommand()]);
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\LogicException
     */
    public function testSlimBridgeConfigPathNotExist()
    {
        new ApplicationWithIncorrectSlimBridgeConfigPath();
    }
}


/**
 * Class TestCommand
 * @package Fr05t1k\SlimExampleTests\Unit\Console
 */
class TestCommand extends Command
{

    /**
     * TestCommand constructor.
     */
    public function __construct()
    {
        parent::__construct('test');
    }
}

/**
 * Class ApplicationWithIncorrectSlimBridgeConfigPath
 * @package Fr05t1k\SlimExampleTests\Unit\Console
 */
class ApplicationWithIncorrectSlimBridgeConfigPath extends Application
{
    /**
     * @return string
     */
    protected function getSlimBridgeConfigPath()
    {
        return '';
    }

}
