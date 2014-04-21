<?php

namespace Wordy\Seed;

use Faker\Factory;

class Populator
{
    private $io;
    private $faker;

    /**
     * @param string $seedFile
     * @param string $locale
     */
    public function __construct($seedFile, $locale = Factory::DEFAULT_LOCALE)
    {
        $this->io       = new IO($seedFile, $locale);
        $this->faker    = Factory::create($locale);
    }

    /**
     * @param int $rounds
     * @param string $type
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function execute($rounds = 10, $type = 'firstName')
    {
        $words = array();
        for ($i=0; $i < $rounds; $i++) {
            $words[] = $this->faker->unique()->$type;
        }

        return $this->io->write($words);
    }

}
