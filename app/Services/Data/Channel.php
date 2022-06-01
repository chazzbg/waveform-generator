<?php

namespace App\Services\Data;

class Channel
{
    /** @var array */
    private $monologue;

    public function addToMonologue($segment)
    {
        $this->monologue[] = $segment;
    }


    public function getMonologue()
    {
        return $this->monologue;
    }

    public function getEndTime()
    {
        return last(last($this->monologue));
    }
}
