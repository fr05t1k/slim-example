<?php

namespace Fr05t1k\SlimExample\Console;

use DI\ContainerBuilder;
use Fr05t1k\SlimExample\ConfigureContainerTrait;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Class ConsoleApplication
 * @package Fr05t1k\SlimExample\Console
 */
class Application extends \Symfony\Component\Console\Application
{
    use ConfigureContainerTrait;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsoleApplication constructor.
     *
     * @param string $name
     * @param string $version
     */
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        $containerBuilder = new ContainerBuilder;

        if (!file_exists($this->getSlimBridgeConfigPath())) {
            throw new LogicException(
                sprintf(
                    "Slim bridge php-di config does not exist. Please check path %s",
                    $this->getSlimBridgeConfigPath()
                )
            );
        }

        $containerBuilder->addDefinitions($this->getSlimBridgeConfigPath());
        $this->configureContainer($containerBuilder);
        $this->container = $containerBuilder->build();

        parent::__construct($name, $version);
    }

    /**
     * Added possibility to add command by class name
     *
     * @see Application::AddCommands()
     * @param array $commands
     */
    public function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            // Let's Figure out command is className or instance of Command
            if (is_string($command)) {
                // Check if given class exists
                if (!class_exists($command)) {
                    throw new LogicException(
                        sprintf(
                            "Class of command %s does not exist",
                            $command
                        )
                    );
                }
                $this->addCommandByClassName($command);
            } else {
                // check is command instance of Command exactly
                if ($command instanceof Command) {
                    $this->add($command);
                } else {
                    throw new LogicException(
                        sprintf(
                            "The command %s MUST be an instance of %s",
                            get_class($command),
                            Command::class
                        )
                    );
                }
            }
        }
    }

    /**
     * PHP-DI slim bridge config path
     * Default settings for container
     *
     * @return string
     */
    protected function getSlimBridgeConfigPath()
    {
        return __DIR__ . '/../../vendor/php-di/slim-bridge/src/config.php';
    }


    /**
     * Add command by class name
     *
     * @param string $className
     * @return Command
     */
    public function addCommandByClassName($className)
    {
        $command = $this->container->get($className);

        if ($command instanceof Command) {
            $this->add($command);
            return $command;
        }

        throw new LogicException(sprintf(
            'Command %s MUST be instance of %s',
            $className,
            Command::class
        ));
    }
}
