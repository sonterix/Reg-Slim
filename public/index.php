<?php
require __DIR__ . '/../vendor/autoload.php';

session_start();

// instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// set up dependencies
require __DIR__ . '/../src/dependencies.php';

// register middleware
require __DIR__ . '/../src/middleware.php';

// register routes
require __DIR__ . '/../src/routes.php';

// run app
$app->run();
