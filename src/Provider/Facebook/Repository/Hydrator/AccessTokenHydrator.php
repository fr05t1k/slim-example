<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\Facebook\Repository\Hydrator;

use Fr05t1k\SlimExample\Provider\AccessToken\AccessTokenInterface;
use Zend\Hydrator\HydratorInterface;

class AccessTokenHydrator implements HydratorInterface
{

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  AccessTokenInterface $object
     * @return AccessTokenInterface
     */
    public function hydrate(array $data, $object)
    {
        $object->setValue($data['value'] ?? '');
        $object->setId($data['_id'] ?? '');

        return $object;
    }

    /**
     * Extract values from an object
     *
     * @param  AccessTokenInterface $object
     * @return array
     */
    public function extract($object)
    {
        return [
            '_id' => $object->getId(),
            'value' => $object->getValue(),
        ];
    }
}