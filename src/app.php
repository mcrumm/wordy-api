<?php

use Wordy\Seed\IO;
use Wordy\Entity\WordManager;
use Silex\Application;

$config = require __DIR__.'/../config/config.php';
$app    = new Application($config);

// Share Wordy\Seed\IO
$app['seed'] = $app->share(function() use ($app) {
    return new IO($app['seedFile'], $app['locale']);
});

// Share Wordy\Entity\WordManager
$app['word_manager'] = $app->share(function() use ($app) {
    return new WordManager($app['seed']);
});

return $app;
