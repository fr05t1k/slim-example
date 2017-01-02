<?php

namespace Fr05t1k\SlimExampleTests\Unit\Component\MongoDB;

use Fr05t1k\SlimExample\Component\MongoDB\DateConverter;
use MongoDB\BSON\UTCDateTime;

/**
 * Class DateConverterTest
 * @package Fr05t1k\SlimExampleTests\Unit\Component\MongoDB
 */
class DateConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testFromDateTimeToUTCDateTime()
    {
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set('Europe/Moscow');
        $datetime = new \DateTime('2015-01-01');
        $utc = DateConverter::fromDateTimeToUTCDateTime($datetime);

        static::assertEquals($utc->toDateTime(), $datetime);
        date_default_timezone_set($oldTimezone);
    }

    public function testFromUTCDateTimeToDateTime()
    {
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set('Europe/Moscow');
        $utc = new UTCDateTime(time() * 1000);

        $datetime = DateConverter::fromUTCDateTimeToDateTime($utc);
        static::assertEquals($utc->toDateTime(), $datetime);
        date_default_timezone_set($oldTimezone);
    }
}
