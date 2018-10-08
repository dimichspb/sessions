<?php
namespace tests\repositories;

use ActiveRecord\DatabaseException;
use app\models\Location;
use PHPUnit\Framework\TestCase;
use Silex\Application;

/**
 * Class ActiveRecordLocationRepositoryTest
 * @package tests\repositories
 */
class ActiveRecordLocationRepositoryTest extends TestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Location
     */
    protected $location;

    /**
     * SetUp tests
     */
    protected function setUp()
    {
        $this->createApplication();
        $this->clear();

        $this->location = new Location();
        $this->location->ip = '111.111.111.111';
        $this->location->country = 'UK';
        $this->location->city = 'London';
    }

    /**
     * Tests Location is being saved successfully
     */
    public function testSaveSuccess()
    {
        $this->assertTrue($this->location->save());
    }

    /**
     * Tests that Location duplicate is not allowed
     */
    public function testSaveDuplicateFailed()
    {
        $this->location->save();

        $location = new Location();
        $location->ip = $this->location->ip;
        $location->country = $this->location->country;
        $location->city = $this->location->city;

        $this->expectException(DatabaseException::class);
        $location->save();

        $this->assertFalse($location->save());
    }

    /**
     * Tests saving Location with wrong IP address
     */
    public function testSaveIpFailed()
    {
        $this->location->ip = 'This is not valid IP address';
        $this->expectException(DatabaseException::class);
        $this->location->save();
    }

    /**
     * Tests saving Location with wrong Country name
     */
    public function testSaveCountryFailed()
    {
        $this->location->country = 'This is not valid Country name';
        $this->expectException(DatabaseException::class);
        $this->location->save();
    }

    /**
     * Tests saving Location with wrong City name
     */
    public function testSaveCityFailed()
    {
        $this->location->city = 'This is not valid City name - very long';
        $this->expectException(DatabaseException::class);
        $this->location->save();
    }
    /**
     * Tests finding by IP is success when Location exists
     * @depends testSaveSuccess
     */
    public function testFindByIpSuccess()
    {
        $this->location->save();

        $location = Location::find_by_ip('111.111.111.111');

        $this->assertNotNull($location);
        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals($this->location->ip, $location->ip);
        $this->assertEquals($this->location->country, $location->country);
        $this->assertEquals($this->location->city, $location->city);
    }

    /**
     * Tests finding by IP is failed when Location does not exist
     */
    public function testFindByIpFailed()
    {
        $location = Location::find_by_ip('111.111.111.111');

        $this->assertNull($location);
    }

    /**
     * Creates Application in dev mode
     * @return Application
     */
    public function createApplication()
    {
        /** @var Application $app */
        $app = require __DIR__ . '/../../src/app.php';
        require __DIR__ . '/../../config/dev.php';
        require __DIR__ . '/../../src/controllers.php';
        $app['session.test'] = true;

        return $this->app = $app;
    }

    /**
     * Clears Location storage
     */
    protected function clear()
    {
        $locations = Location::all();
        foreach ($locations as $location) {
            $location->delete();
        }
    }
}