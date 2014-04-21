<?php

use Guzzle\Log\MessageFormatter;
use Guzzle\Log\PsrLogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Symfony\Component\Console\Application;
use Wordy\Console\Command;

// Setup the Guzzle Client, including the Logger Plugin
$app['wordy.client'] = $app->share(function() use ($app) {

    // Set base_url from config.php
    $client = \Wordy\WordyClient::factory(array(
        'base_url' => $app['base_url']
    ));

    // Log requests sent via Guzzle
    $logPlugin  = new LogPlugin(new PsrLogAdapter($app['monolog']), MessageFormatter::DEBUG_FORMAT);
    $client->addSubscriber($logPlugin);

    return $client;
});

// Create the Console Application
$console = new Application('Wordy API', 'n/a');
$console->setDispatcher($app['dispatcher']);

// Auto-register commands
$cmdNamespace = 'Wordy\\Console\\Command\\';
$cmdPath = __DIR__.'/'.str_replace('\\', '/', $cmdNamespace);
foreach (glob($cmdPath.'*Command.php') as $cmd) {
    $cmdName = str_replace(array($cmdPath, '.php'), '', $cmd);
    $klass = "\\".$cmdNamespace.$cmdName;
    $refl = new ReflectionClass($klass);
    if (!$refl->isAbstract()) {
        $command = $klass::getInstance($app);
        $console->add($command);
    }
}

return $console;
