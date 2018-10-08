<?php

use app\services\ActiveRecordServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/app_dev.log',
));

$app->register(new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
));

$models = __DIR__ . '/../src/app/models';

$app->register(new ActiveRecordServiceProvider(), array(
    'ar.models' => $models,
    'ar.connection' => 'mysql://sessions_test:sessions_test@localhost/sessions_test',
));