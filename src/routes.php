<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Routes
 * 
 * $this->logger->info - log message
 * $this->renderer->render - render view
 */

$app->get('/', function (Request $request, Response $response) {
    $this->logger->info("Home page '/' route");
    return $this->renderer->render($response, 'index.phtml');
});

// Autorisation

$app->get('/registration', function (Request $request, Response $response) {
    $this->logger->info("Registration page '/registration' route");
    return $this->renderer->render($response, 'registration.phtml');
})->add($sessionCheck);

$app->post('/registration', 'App\Controller\UserController:registration')->add($validationData)->add($sessionCheck);

$app->get('/login', function (Request $request, Response $response) {
    $this->logger->info("Login page '/login' route");
    return $this->renderer->render($response, 'login.phtml');
})->add($sessionCheck);

$app->post('/login', 'App\Controller\UserController:login')->add($validationData)->add($sessionCheck);

$app->get('/logout', 'App\Controller\UserController:logout');

// Balans

$app->get('/balans', function (Request $request, Response $response) {
    $this->logger->info("Login page '/balans' route");
    return $this->renderer->render($response, 'balans.phtml');
})->add($sessionValidation);

$app->post('/addBalans', 'App\Controller\BalansController:addBalans')->add($validationData)->add($sessionValidation);

$app->post('/takeOffBalans', 'App\Controller\BalansController:takeOffBalans')->add($validationData)->add($sessionValidation);

$app->get('/getBalans/{id}', 'App\Controller\BalansController:getBalans');

// Map

$app->get('/map', function (Request $request, Response $response) {
    $this->logger->info("Login page '/map' route");
    return $this->renderer->render($response, 'map.phtml');
});

$app->post('/getDistance', 'App\Controller\MapController:getDistance')->add($validationData);
