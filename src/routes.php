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

$app->get('/registration', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Registration page '/registration' route");
    // render index view
    return $this->renderer->render($response, 'registration.phtml');
})->add($sessionCheck);

$app->post('/registration', 'App\Controller\user:registration')->add($formValidation);

$app->get('/login', function (Request $request, Response $response) {
    // log message
    $this->logger->info("Login page '/login' route");
    // render index view
    return $this->renderer->render($response, 'login.phtml');
})->add($sessionCheck);

$app->post('/login', 'App\Controller\user:login')->add($formValidation);

$app->get('/logout', 'App\Controller\user:logout');
