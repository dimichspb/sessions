<?php

// configure your app for the production environment

use app\services\ActiveRecordServiceProvider;
use Silex\Provider\MonologServiceProvider;

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/app_prod.log',
));

$models = __DIR__ . '/../src/app/models';

$app->register(new ActiveRecordServiceProvider(), array(
    'ar.models' => $models,
    'ar.connection' => 'mysql://sessions:sessions@localhost/sessions',
));

