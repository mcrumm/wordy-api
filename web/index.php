<?php

use Symfony\Component\HttpFoundation\Request;

// Only allow access from the local server.
// This code should be not used in a production environment.
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once __DIR__.'/../vendor/autoload.php';

Request::setTrustedProxies(array('127.0.0.1', 'fe80::1', '::1'));

/** @var \Silex\Application $app */
$app = require __DIR__.'/../src/controllers.php';
$app->run();
