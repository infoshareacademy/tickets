<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/hello/{name}', function ($name) use ($app) {
    $zmienna = array();
    $zmienna = [0 => array('name' => 'Anna',
    'email' => 'ghjkl@hjk.com'), 1 => array('name' => 'Kasia', 'email' => 'ghjk@hjkl.com')];
//    return 'Hello '.$app->escape($name);
    return $app->json($zmienna);
});


$app->run();