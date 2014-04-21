<?php

namespace Wordy;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class WordyClient extends Client
{
    const DEFAULT_URL = 'http://localhost/';

    /**
     * {@inheritDoc}
     * @return WordyClient
     */
    static public function factory($config = array())
    {
        $default = array( 'base_url' => self::DEFAULT_URL );
        $required = array( 'base_url' );

        $config = Collection::fromConfig($config, $default, $required);
        $client = new self($config['base_url'], $config);

        $client->setDescription(ServiceDescription::factory(__DIR__.'/Resources/webservices/wordy.php'));

        return $client;
    }

}
