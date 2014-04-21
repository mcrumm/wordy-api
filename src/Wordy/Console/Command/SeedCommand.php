<?php

namespace Wordy\Console\Command;

use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedCommand extends AbstractCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('seed:generate')
            ->setDescription('Seeds the word collection')
            ->setDefinition(array(
                new InputArgument('num', InputArgument::OPTIONAL, 'The number of words to generate', 10),
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $numWords = $input->getArgument('num');
            $words = $this->client->getCommand('Seed', array( 'num' => $numWords ))->execute();
            foreach ($words as $word) {
                $output->writeln(print_r($word, true));
            }
        }
        catch (BadResponseException $ex) {
            if ($output->getVerbosity() > OutputInterface::VERBOSITY_NORMAL) {
                throw $ex;
            } else {
                $response = $ex->getResponse();
                $output->writeln(sprintf('<error>Error: %d %s</error>',
                    $response->getStatusCode(),
                    $response->getReasonPhrase()
                ));
            }
        }
    }

}
