<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Component\MongoDB;

use MongoDB\BSON\UTCDatetime;

/**
 * Class DateConverter
 * @package Fr05t1k\SlimExample\Component\MongoDB
 */
class DateConverter
{
    /**
     * @param \DateTime $dateTime
     *
     * @return UTCDatetime
     */
    public static function fromDateTimeToUTCDateTime(\DateTime $dateTime)
    {
        $utcTimestamp = $dateTime->getTimestamp();
        return new UTCDatetime($utcTimestamp * 1000);
    }

    /**
     * @param UTCDatetime $UTCDateTime
     * @return \DateTime
     */
    public static function fromUTCDateTimeToDateTime(UTCDatetime $UTCDateTime)
    {
        $timezone = (new \DateTime())->getTimezone();
        /** @noinspection PhpUndefinedMethodInspection */
        return $UTCDateTime->toDateTime()->setTimezone($timezone);
    }
}
