<?php

namespace Wordy\Seed;

use Faker\Factory;

class Sorter
{
    private $collator;

    /**
     * @param string $locale
     */
    public function __construct($locale = Factory::DEFAULT_LOCALE)
    {
        $this->collator = \Collator::create($locale);
    }

    /**
     * @param $data
     * @throws \RuntimeException
     */
    public function execute(&$data)
    {
        if (false === $this->collator->sort($data)) {
            throw new \RuntimeException('Collator failed to sort the data.');
        }
    }

}
