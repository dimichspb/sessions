<?php

$console = require ('console.php');

$connection = new mysqli(
    'localhost',
    'sessions',
    'sessions',
    'sessions'
);
$console->add(new \app\commands\MigrateUpCommand($connection));
$console->add(new \app\commands\MigrateDownCommand($connection));

return $console;
