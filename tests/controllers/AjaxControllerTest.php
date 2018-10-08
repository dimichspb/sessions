<?php
namespace tests\controllers;

use app\models\Location;
use app\services\LocationService;
use ipinfo\ipinfo\Details;
use ipinfo\ipinfo\IPinfo;
use Silex\WebTestCase;

/**
 * Class AjaxControllerTest
 * @package tests\controllers
 */
class AjaxControllerTest extends WebTestCase
{
    /**
     * Tests ajax/ip POST request
     */
    public function testPostIp()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('POST', '/ajax/ip');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(
            json_encode($this->getDetailsMock()),
            $client->getResponse()->getContent()
        );
    }

    /**
     * Tests ajax/location POST request when Location does not exist
     */
    public function testPostLocationNotExists()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('POST', '/ajax/location', ['ip' => '222.222.222.222']);

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(
            json_encode($this->getDetailsMock()),
            $client->getResponse()->getContent()
        );

    }

    /**
     * Tests ajax/location POST request when Location exists
     */
    public function testPostLocationExists()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $client->request('POST', '/ajax/location', ['ip' => '111.111.111.111']);

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(
            json_encode($this->getLocationMock()),
            $client->getResponse()->getContent()
        );

    }

    /**
     * Creates Application in dev mode
     * @return mixed|\Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../src/app.php';
        require __DIR__ . '/../../config/dev.php';
        require __DIR__ . '/../../src/controllers.php';
        $app['session.test'] = true;
        $app['ip.info'] = function($app) {
            return $this->getIpInfoMock();
        };
        $app['location'] = function($app) {
            return $this->getLocationServiceMock();
        };

        return $this->app = $app;
    }

    /**
     * Creates IPInfo SDK Mock
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getIpInfoMock()
    {
        $mock = $this->createMock(IPinfo::class);

        $mock->method('getDetails')->willReturn($this->getDetailsMock());
        return $mock;
    }

    /**
     * Creates LocationService Mock
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getLocationServiceMock()
    {
        $mock = $this->createMock(LocationService::class);

        $mock->method('get')->will($this->returnCallback([$this, 'getCallback']));

        $mock->method('create')->willReturn($this->getLocationMock());

        return $mock;
    }

    /**
     * Callback function for LocationService::get() method
     * @return Location|null
     */
    public function getCallback()
    {
        $args = func_get_args();

        if ($args[0] === '111.111.111.111') {
            return $this->getLocationMock();
        }
        return null;
    }

    /**
     * Creates Details object mock
     * @return Details
     */
    protected function getDetailsMock()
    {
        $mock = $this->createMock(Details::class);
        $mock->ip = '111.111.111.111';
        $mock->country = 'UK';
        $mock->city = 'London';

        return $mock;
    }

    /**
     * Creates Location object Mock
     * @return Location
     */
    protected function getLocationMock()
    {
        $mock = $this->createMock(Details::class);
        $mock->ip = '111.111.111.111';
        $mock->country = 'UK';
        $mock->city = 'London';

        return $mock;
    }
}