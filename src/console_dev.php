<?php

$console = require ('console.php');

$connection = new mysqli(
    'localhost',
    'sessions_test',
    'sessions_test',
    'sessions_test'
);
$console->add(new \app\commands\MigrateUpCommand($connection));
$console->add(new \app\commands\MigrateDownCommand($connection));

return $console;
