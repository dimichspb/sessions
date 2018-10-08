<?php
namespace tests\models;

use app\models\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
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