<?php

namespace Wordy\Controller;

use Wordy\Entity\WordManager;

class AbstractController
{
    /** @var \Wordy\Entity\WordManager */
    protected $wm;

    /**
     * @param WordManager $wm
     */
    public function __construct(WordManager $wm)
    {
        $this->wm = $wm;
    }

}
