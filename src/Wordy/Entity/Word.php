<?php

namespace Wordy\Entity;

use Guzzle\Common\ToArrayInterface;

/**
 * @SWG\Model(id="Word")
 */
class Word implements ToArrayInterface
{
    /**
     * @var string
     * @SWG\Property(name="word", type="string")
     */
    public $word;

    /**
     * @var string
     * @SWG\Property(name="metaphone", type="string")
     */
    public $metaphone;

    /**
     * @var string
     * @SWG\Property(name="length", type="integer")
     */
    public $length;

    /**
     * @param string $word
     */
    public function __construct($word)
    {
        $this->metaphone    = metaphone($word);
        $this->length       = strlen($word);
        $this->word         = $word;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'word'      => $this->word,
            'metaphone' => $this->metaphone,
            'length'    => $this->length
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->word;
    }

}
