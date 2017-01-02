<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Component\Entity;

/**
 * Interface Arrayable
 * @package Fr05t1k\SlimExample\Component\Entity
 */
interface Arrayable
{
    /**
     * @return mixed
     */
    public function toArray(): array;
}