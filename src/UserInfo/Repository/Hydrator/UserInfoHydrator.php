<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\UserInfo\Repository\Hydrator;

use Fr05t1k\SlimExample\Component\MongoDB\DateConverter;
use Fr05t1k\SlimExample\UserInfo\UserInfoInterface;
use Zend\Hydrator\HydratorInterface;

/**
 * Class UserInfoHydrator
 * @package Fr05t1k\SlimExample\Repository\Hydrator
 */
class UserInfoHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  UserInfoInterface $object
     * @return array
     */
    public function extract($object)
    {
        return [
            '_id' => $object->getId(),
            'lastName' => $object->getLastName(),
            'firstName' => $object->getFirstName(),
            'email' => $object->getEmail(),
            'birthday' => $object->getBirthday() !== null ?
                DateConverter::fromDateTimeToUTCDateTime($object->getBirthday()) : null,
        ];
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  \Fr05t1k\SlimExample\UserInfo\UserInfoInterface $object
     * @return UserInfoInterface
     */
    public function hydrate(array $data, $object)
    {
        $object->setFirstName($data['firstName'] ?? $object->getFirstName());
        $object->setLastName($data['lastName'] ?? $object->getLastName());
        $object->setEmail($data['email'] ?? $object->getEmail());
        if (array_key_exists('birthday', $data) && $data['birthday'] !== null) {
            $object->setBirthday(DateConverter::fromUTCDateTimeToDateTime($data['birthday']));
        }
        $object->setId($data['_id'] ?? $object->getId());

        return $object;
    }
}
