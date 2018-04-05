<?php
// Application middleware

$formValidation = function($request, $response, $next) {
    if($request->isPost() == false) {
        return $response->withStatus(405);
    }

    $data = [
        'login' => trim($request->getParam('login')),
        'password' => trim($request->getParam('pass'))
    ];

    foreach($data as $value) {
        if(!$value) { 
            return $response->withStatus(403)
                ->withJson('Empty data');
        }
    }

    $response = $next($request, $response);
    return $response;
};

$sessionCheck = function($request, $response, $next) {
    if($_SESSION['authorized']) {
        return $response->withStatus(403)
            ->withJson('You are already login');
    }

    $response = $next($request, $response);
    return $response;
};