<?php

namespace Fr05t1k\SlimExample\Component\Entity;

use Zend\Hydrator\HydratorAwareTrait;

/**
 * Abstract class for all entity
 * Entities should be hydratable and extractable
 *
 * @package Fr05t1k\SlimExample\Entity
 */
abstract class Entity
{
    use HydratorAwareTrait;
}
