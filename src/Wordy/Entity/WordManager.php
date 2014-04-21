<?php

namespace Wordy\Entity;

use Wordy\Seed\IO;

class WordManager
{
    private $io;

    /**
     * @param IO $io
     */
    function __construct(IO $io)
    {
        $this->io = $io;
    }

    /**
     * @return array|boolean
     * @throws \InvalidArgumentException
     */
    public function getAll()
    {
        return Collector::fromPrimitive($this->io->read());
    }

    /**
     * @param string|Word $word
     * @return array
     * @throws \RuntimeException
     */
    public function add($word)
    {
        try {
            return $this->io->append(array( (string) $word ));
        }
        catch (\Exception $ioProblem) {
            throw new \RuntimeException(sprintf('The word "%s" could not be added.', $word), 0, $ioProblem);
        }
    }

    /**
     * @param $word
     * @return array|bool
     */
    public function find($word)
    {
        $words = array_filter($this->getAll(), function($item) use ($word) {
            return (string) $item == $word;
        });

        return !empty($words) ? array( 'words' => $words ) : false;
    }

    /**
     * @param $position
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function get($position)
    {
        $words = $this->getAll();

        if ($position < 0) {
            throw new \InvalidArgumentException('Position must be a positive integer.');
        } elseif (!isset($words[$position])) {
            throw new \RuntimeException(sprintf('No word found at position %d.', $position));
        }

        return $words[$position];
    }

    /**
     * @param array $words
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function set(array $words = array())
    {
       return $this->io->write(Collector::toPrimitive($words));
    }

    /**
     * @param $position
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function remove($position)
    {
        $words = $this->getAll();
        if ($position < 0) {
            throw new \InvalidArgumentException('Position must be greater than or equal to zero.');
        } elseif (!isset($words[$position])) {
            throw new \RuntimeException(sprintf('No word found at position %d.', $position));
        }

        unset($words[$position]);

        $this->io->write($words);
    }

}
