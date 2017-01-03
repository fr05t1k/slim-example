<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample;

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ApcuCache;

/**
 * Class ConfigureContainerTrait
 * @package Fr05t1k\SlimExample
 */
trait ConfigureContainerTrait
{
    /**
     * Configure container with definitions and use cache (apcu)
     *
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/../configs/services.php');
        $builder->addDefinitions(__DIR__ . '/../configs/config.php');

        if (getenv('SLIM_EXAMPLE_DI_CACHE') && extension_loaded('apcu')) {
            $cache = new ApcuCache();
            if ($cachePrefix = getenv('SLIM_EXAMPLE_CACHE_PREFIX')) {
                $cache->setNamespace($cachePrefix);
            }
            $builder->setDefinitionCache($cache);
        }
    }
}
