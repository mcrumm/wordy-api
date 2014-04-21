<?php

use JDesrosiers\Silex\Provider\CorsServiceProvider;
use JDesrosiers\Silex\Provider\SwaggerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Wordy\Controller;

/** @var \Silex\Application $app */
$app = require __DIR__.'/../src/app.php';

/**
 * Before Middleware to parse a JSON request body.
 * @link http://silex.sensiolabs.org/doc/cookbook/json_request_body.html
 */
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// API Request Logger
$app->register(new MonologServiceProvider(), array(
    'monolog.name' => 'wordy',
    'monolog.logfile' => __DIR__.'/../var/logs/api.log',
));

// Controllers

$app->register(new ServiceControllerServiceProvider());

// /seed Generates the word collection

$app['seed.controller'] = $app->share(function() use ($app) {
    return new Controller\SeedController(new \Wordy\Seed\Populator($app['seedFile'], $app['locale']));
});

$app->post('/seed/{n}',         'seed.controller:generateAction');
$app->post('/seed/populate',    'seed.controller:populateAction');

// /search Provides a basic word search

$app['search.controller'] = $app->share(function() use ($app) {
    return new Controller\SearchController($app['word_manager']);
});

$app->post('/search/{word}',    'search.controller:indexAction');

// /words Provides the word CRUD

$app['words.controller'] = $app->share(function() use ($app) {
    return new Controller\WordsController($app['word_manager']);
});

$app->post('/words/',            'words.controller:createAction');
$app->get('/words/',            'words.controller:indexAction');
$app->get('/words/{pos}',       'words.controller:getAction');
$app->delete('/words/{pos}',    'words.controller:deleteAction');

// /werds Exposes a known issue in Guzzle Service Descriptions

$app['werds.controller'] = $app->share(function() use ($app) {
    return new Controller\WerdsController($app['word_manager']);
});

$app->get('/werds/',            'werds.controller:indexAction');

// HTTP Error Handler

$app->error(function (\Exception $e, $code) use ($app) {
    $app->json(array( 'error' => $e->getMessage() ), $code);
});

return $app;