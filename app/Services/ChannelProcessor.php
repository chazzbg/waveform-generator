<?php

namespace App\Services;

use App\Services\Data\Channel;

class ChannelProcessor
{
    public function __construct(private FileDataReader $reader)
    {

    }


    public function process($path): Channel
    {
        $channel = new Channel();
        $monologue = $this->reader->read($path);

        $segment = [0];
        foreach ($monologue as $parts) {

            if($parts['command'] === 'silence_start') {
                $segment[] = (float)$parts['timestamp'];
                $channel->addToMonologue($segment);
            }

            if($parts['command'] === 'silence_end'){
                $segment = [(float)$parts['timestamp']];
            }
        }
        return $channel;
    }
}
