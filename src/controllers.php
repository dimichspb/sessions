<?php

use app\controllers\AjaxController;
use app\controllers\SiteController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//Request::setTrustedProxies(array('127.0.0.1'));

$app['site.controller'] = function() use ($app) {
    return new SiteController($app['twig'], $app['form.factory']);
};

$app['ajax.controller'] = function() use ($app) {
    return new AjaxController($app['ip.info'], $app['location']);
};

$app->get('/', function(Request $request) use ($app) {
    return $app['site.controller']->actionIndex($request);
});

$app->post('/ajax/ip', function(Request $request) use ($app) {
    return $app['ajax.controller']->actionIp($request);
});

$app->post('/ajax/location', function(Request $request) use ($app) {
    return $app['ajax.controller']->actionLocation($request);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
