<?php
namespace app\services;

use app\repositories\LocationRepositoryInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class LocationServiceProvider
 * @package app\services
 */
class LocationServiceProvider implements ServiceProviderInterface
{
    /**
     * Register LocationService
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['location'] = function($app) {
            return new LocationService($app[LocationRepositoryInterface::class]);
        };
    }
}