<?php
// Application middleware

$validationData = function($request, $response, $next) {
    if($request->isPost() == false) {
        return $response->withStatus(405);
    }

    foreach($request->getParsedBody() as $value) {
        $val =  trim($value);
        if(!$val) { 
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