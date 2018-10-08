<?php
namespace tests\controllers;

use Silex\WebTestCase;

/**
 * Class siteControllerTest
 * @package tests\controllers
 */
class siteControllerTest extends WebTestCase
{
    /**
     * Tests homepage
     */
    public function testGetHomepage()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('Welcome to 24Sessions test assignment', $crawler->filter('body')->text());
        $this->assertContains('Ip', $crawler->filter('body form')->text());
        $this->assertContains('Location', $crawler->filter('body form')->text());

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

        return $this->app = $app;
    }
}
