<?php
namespace app\services;

use app\repositories\LocationRepositoryInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LocationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['location'] = function($app) {
            return new LocationService($app[LocationRepositoryInterface::class]);
        };
    }
}