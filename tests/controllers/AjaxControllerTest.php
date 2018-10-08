<?php
namespace tests\controllers;

use app\models\Location;
use app\services\LocationService;
use ipinfo\ipinfo\Details;
use ipinfo\ipinfo\IPinfo;
use Silex\WebTestCase;

class AjaxControllerTest extends WebTestCase
{
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

    protected function getIpInfoMock()
    {
        $mock = $this->createMock(IPinfo::class);

        $mock->method('getDetails')->willReturn($this->getDetailsMock());
        return $mock;
    }

    protected function getLocationServiceMock()
    {
        $mock = $this->createMock(LocationService::class);

        $mock->method('get')->will($this->returnCallback([$this, 'getCallback']));

        $mock->method('create')->willReturn($this->getLocationMock());

        return $mock;
    }

    public function getCallback()
    {
        $args = func_get_args();

        if ($args[0] === '111.111.111.111') {
            return $this->getLocationMock();
        }
        return null;
    }

    protected function getDetailsMock()
    {
        $mock = $this->createMock(Details::class);
        $mock->ip = '111.111.111.111';
        $mock->country = 'UK';
        $mock->city = 'London';

        return $mock;
    }

    protected function getLocationMock()
    {
        $mock = $this->createMock(Details::class);
        $mock->ip = '111.111.111.111';
        $mock->country = 'UK';
        $mock->city = 'London';

        return $mock;
    }
}