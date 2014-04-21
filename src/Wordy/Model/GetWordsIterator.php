<?php

namespace Wordy\Model;

use Guzzle\Service\Resource\ResourceIterator;

class GetWordsIterator extends ResourceIterator
{
    /**
     * Send a request to retrieve the next page of results.
     *
     * @return array Returns the newly loaded resources
     */
    protected function sendRequest()
    {
        // If a next token is set, then add it to the command
        if ($this->nextToken) {
            $this->command->set('page', $this->nextToken);
        }

        // Execute the command and parse the result
        $result = $this->command->execute();

        // Find the next token in the result metadata
        if (!isset($result['meta'])) {
            $this->nextToken = false;
        } else {
            $meta       = $result['meta'];
            $nextPage   = $meta['page'] + 1;
            $this->nextToken = $nextPage <= $meta['pages'] ? $nextPage : false;
        }

        // Return the actual result data
        return $result['words'];
    }

}
 