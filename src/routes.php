<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Home page '/' route");
    // render index view
    return $this->renderer->render($response, 'index.phtml');
});

// Autorisation

$app->get('/registration', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Registration page '/registration' route");
    // render index view
    return $this->renderer->render($response, 'registration.phtml');
})->add($sessionCheck);

$app->post('/registration', 'App\Controller\user:registration')->add($validationData)->add($sessionCheck);

$app->get('/login', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Login page '/login' route");
    // render index view
    return $this->renderer->render($response, 'login.phtml');
})->add($sessionCheck);

$app->post('/login', 'App\Controller\user:login')->add($validationData)->add($sessionCheck);

$app->get('/logout', 'App\Controller\user:logout');

// Balans

$app->get('/balans', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Login page '/balans' route");
    // render index view
    return $this->renderer->render($response, 'balans.phtml');
})->add($sessionValidation);

$app->post('/addBalans', 'App\Controller\user:addBalans')->add($validationData)->add($sessionValidation);

$app->post('/takeOffBalans', 'App\Controller\user:takeOffBalans')->add($validationData)->add($sessionValidation);

$app->get('/getBalans/{id}', 'App\Controller\user:getBalans');

// Map

$app->get('/map', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Login page '/map' route");
    // render index view
    return $this->renderer->render($response, 'map.phtml');
});

$app->post('/getDistance', 'App\Controller\user:getDistance')->add($validationData);


