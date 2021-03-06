<?php
namespace tests\services;

use app\models\Location;
use app\repositories\LocationRepositoryInterface;
use app\services\LocationService;
use PHPUnit\Framework\TestCase;

/**
 * Class LocationServiceTest
 * @package tests\services
 */
class LocationServiceTest extends TestCase
{
    /**
     * Tests getting Location by IP success when repository returns Location
     */
    public function testGetSuccess()
    {
        $location = $this->getLocationMock();
        $repository = $this->getRepositoryMock($location);
        $service = new LocationService($repository);

        $found = $service->get('111.111.111.111');

        $this->assertNotNull($found);
        $this->assertInstanceOf(Location::class, $found);
        $this->assertEquals($location->ip, $found->ip);
        $this->assertEquals($location->country, $found->country);
        $this->assertEquals($location->city, $found->city);
    }

    /**
     * Tests getting Location by IP fails when repository returns null
     */
    public function testGetFailed()
    {
        $repository = $this->getRepositoryMock(null);
        $service = new LocationService($repository);

        $found = $service->get('111.111.111.111');

        $this->assertNull($found);
    }

    /**
     * Tests creation of Location success
     */
    public function testCreateSuccess()
    {
        $location = $this->getLocationMock();
        $repository = $this->getRepositoryMock($location);
        $service = new LocationService($repository);

        $new = $service->create($location->ip, $location->country, $location->city);

        $this->assertNotNull($new);
        $this->assertInstanceOf(Location::class, $new);
        $this->assertEquals($location->ip, $new->ip);
        $this->assertEquals($location->country, $new->country);
        $this->assertEquals($location->city, $new->city);
    }

    /**
     * Creates LocationRepository Mock
     * @param $location
     * @return LocationRepositoryInterface
     */
    protected function getRepositoryMock($location)
    {
        $mock = $this->createMock(LocationRepositoryInterface::class);

        $mock->method('get')->willReturn($location);
        $mock->method('create')->willReturn($location);

        return $mock;
    }

    /**
     * Creates Location object Mock
     * @return Location
     */
    protected function getLocationMock()
    {
        $mock = $this->createMock(Location::class);
        $mock->ip = '111.111.111.111';
        $mock->country = 'UK';
        $mock->city = 'London';

        return $mock;
    }
}