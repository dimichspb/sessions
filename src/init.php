<?php

$link = dirname(__DIR__) . '/web/bootstrap';
$target = dirname(__DIR__) . '/vendor/twbs/bootstrap/dist';

if (!is_dir($link)) {
    symlink($target, $link);
}

$link = dirname(__DIR__) . '/web/jquery';
$target = dirname(__DIR__) . '/vendor/components/jquery';

if (!is_dir($link)) {
    symlink($target, $link);
}