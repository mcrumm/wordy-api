<?php

namespace Wordy\Console\Command;

use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddWordCommand extends AbstractCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('words:add')
            ->setDescription('Adds a word to the collection')
            ->setDefinition(array(
                new InputArgument('word', InputArgument::REQUIRED, 'The word to add.')
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $word   = $input->getArgument('word');
            $result = $this->client->getCommand('AddWord', array('word' => $word))->execute();
            $word = $this->client->get($result['location'])->send();
            $output->writeln(print_r(json_decode($word->getBody(true), true), true));
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
