<?php
namespace app\services;

use ActiveRecord\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Silex\Application;
use Silex\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ActiveRecordServiceProvider implements ServiceProviderInterface, BootableProviderInterface, EventListenerProviderInterface
{
    public function register(Container $app)
    {
        $app['ar.init'] = $app->protect(function () use ($app) {
            $models = $app['ar.models'] ? $app['ar.models'] : '';
            $connection = $app['ar.connection']? $app['ar.connection']: '';

            Config::initialize(function(Config $config) use ($models, $connection) {
                $config->set_model_directory($models);
                $config->set_connections(['default' => $connection]);
                $config->set_default_connection('default');

                return $config;
            });
        });
    }

    public function boot(Application $app)
    {
        $app['ar.init']();
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addListener(KernelEvents::REQUEST, function(GetResponseEvent $event) use ($app) {
            // do something
        });
    }
}