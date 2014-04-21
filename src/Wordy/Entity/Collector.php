<?php

namespace Wordy\Entity;

class Collector
{
    /**
     * @param array $words
     * @return Word[]
     */
    static public function fromPrimitive(array $words = array())
    {
        $wordMapper = function($word) {
            return new Word((string) $word);
        };

        return array_map($wordMapper, $words);
    }

    /**
     * @param array $words
     * @return array
     */
    static public function toPrimitive(array $words = array())
    {
        $stringMapper = function ($word) {
            return (string) $word;
        };

        return array_map($stringMapper, $words);
    }

}
 