<?php

namespace Wordy\Console\Command;

use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetWordsCommand extends AbstractCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('words:all')
            ->setDescription('Retrieves the list of words from the Wordy API')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $words  = $this->client->getIterator('GetWords');
            foreach ($words as $word) {
                $output->writeln(print_r($word, true));
            }
        }
        catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $output->writeln(sprintf('<error>Error: %d %s</error>',
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));
        }
    }

}
