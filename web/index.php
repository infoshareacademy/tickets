<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/tickets', function () use ($app) {
    $router = new \Tickets\Routers\CollectorRouter();
    $tickets = $router->getTickets();

    return new \Symfony\Component\HttpFoundation\Response($tickets);
});


$app->run();