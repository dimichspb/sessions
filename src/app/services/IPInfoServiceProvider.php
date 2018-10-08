<?php
namespace app\services;

use ipinfo\ipinfo\IPinfo;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class IPInfoServiceProvider
 * @package app\services
 */
class IPInfoServiceProvider implements ServiceProviderInterface
{
    /**
     * Register IPInfo SDK as service
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['ip.info'] = function ($app) {
            return new IPinfo($app['ip.token']);
        };
    }
}