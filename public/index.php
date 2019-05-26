<?php

$loader = require(__DIR__ .'/../vendor/autoload.php');
$loader->setPsr4('App\\', __DIR__.'/../app');

$mode = 'dev';
// $mode = 'prod';

(new App\App())->run($mode);