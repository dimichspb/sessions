<?php
namespace app\services;

use ipinfo\ipinfo\IPinfo;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class IPInfoServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['ip.info'] = function ($app) {
            return new IPinfo($app['ip.token']);
        };
    }
}