<?php
namespace tests\models;

use app\models\Location;
use PHPUnit\Framework\TestCase;

/**
 * Class LocationTest
 * @package tests\models
 */
class LocationTest extends TestCase
{
    /**
     * Tests creation of Location
     */
    public function testCreateSuccess()
    {
        $location = new Location();
        $location->ip = $ip = '111.111.111.111';
        $location->country = $country = 'UK';
        $location->city = $city = 'London';

        $this->assertEquals($ip, $location->ip);
        $this->assertEquals($country, $location->country);
        $this->assertEquals($city, $location->city);

    }
}