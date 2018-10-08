<?php
namespace tests\repositories;

use ActiveRecord\DatabaseException;
use app\models\Location;
use PHPUnit\Framework\TestCase;
use Silex\Application;

class ActiveRecordLocationRepositoryTest extends TestCase
{
    protected $app;

    /**
     * @var Location
     */
    protected $location;

    protected function setUp()
    {
        $this->createApplication();
        $this->clear();

        $this->location = new Location();
        $this->location->ip = '111.111.111.111';
        $this->location->country = 'UK';
        $this->location->city = 'London';
    }

    public function testSaveSuccess()
    {
        $this->assertTrue($this->location->save());
    }

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

    public function testSaveIpFailed()
    {
        $this->location->ip = 'This is not valid IP address';
        $this->expectException(DatabaseException::class);
        $this->location->save();
    }

    public function testSaveCountryFailed()
    {
        $this->location->country = 'This is not valid Country name';
        $this->expectException(DatabaseException::class);
        $this->location->save();
    }

    public function testSaveCityFailed()
    {
        $this->location->city = 'This is not valid City name - very long';
        $this->expectException(DatabaseException::class);
        $this->location->save();
    }
    /**
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

    public function testFindByIpFailed()
    {
        $location = Location::find_by_ip('111.111.111.111');

        $this->assertNull($location);
    }

    public function createApplication()
    {
        /** @var Application $app */
        $app = require __DIR__ . '/../../src/app.php';
        require __DIR__ . '/../../config/dev.php';
        require __DIR__ . '/../../src/controllers.php';
        $app['session.test'] = true;

        return $this->app = $app;
    }

    protected function clear()
    {
        $locations = Location::all();
        foreach ($locations as $location) {
            $location->delete();
        }
    }
}