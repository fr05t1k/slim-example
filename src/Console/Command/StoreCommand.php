<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Console\Command;

use Fr05t1k\SlimExample\Handler\Common\StoreHandler;
use Fr05t1k\SlimExample\Provider\ProviderInterface;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StoreCommand
 * @package Fr05t1k\SlimExample\Console\Command
 */
class StoreCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * StoreCommand constructor.
     * @param ContainerInterface $container
     * @param ProviderInterface $provider
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this->setName('user-info:store');
        $this->setDescription('Store user info from token');
        $this->setDefinition(
            new InputDefinition($this->getOptions())
        );
    }

    /**
     * @return array
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    private function getOptions()
    {
        return [
            new InputOption(
                'token',
                't',
                InputOption::VALUE_REQUIRED,
                'Access Token'
            )
        ];
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tokenString = $input->getOption('token');

        if ($tokenString === null || $tokenString === '') {
            return $output->writeln('Please specify token parameter');
        }
        $token = $this->container->get(ProviderInterface::class)->createToken($tokenString);
        $handler = $this->container->get(StoreHandler::class);
        $handler($token);

        return $output->writeln('Stored');
    }
}
