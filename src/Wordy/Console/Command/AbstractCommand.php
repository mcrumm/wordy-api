<?php

namespace Wordy\Console\Command;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Silex\Application;
use Symfony\Component\Console\Command\Command;
use Wordy\WordyClient;

abstract class AbstractCommand extends Command
{
    /** @var \Wordy\WordyClient */
    protected $client;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    /**
     * @param WordyClient $client
     * @param LoggerInterface $logger
     */
    public function __construct(WordyClient $client, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger ?: new NullLogger();

        parent::__construct();
    }

    /**
     * @param Application $app
     * @return static
     */
    static public function getInstance(Application $app)
    {
        return new static($app['wordy.client'], $app['monolog']);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getService($name)
    {
        /** @var \Silex\Application $app */
        $app = $this->getApplication();
        return $app[$name];
    }

}
