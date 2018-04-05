<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true,

        // renderer settings
        'path' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // connect to DB
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'dbname' => 'reg_slim',
            'charset' => 'utf8'
        ],
    ],
];
