<?php

use app\repositories\LocationRepositoryInterface;
use app\services\ActiveRecordServiceProvider;
use app\services\IPInfoServiceProvider;
use app\services\LocationServiceProvider;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new LocaleServiceProvider());

$app->register(new TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
$app->register(new IPInfoServiceProvider(), array(
    'ip.token' => 'bb94b013a4e20e'
));

$app[LocationRepositoryInterface::class] = function ($app) {
    return new \app\repositories\ActiveRecordLocationRepository();
};

$app->register(new LocationServiceProvider());

return $app;
