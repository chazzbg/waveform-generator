<?php

namespace App\Http\Controllers;

use App\Services\ChannelProcessor;
use App\Services\DialogueStats;
use Illuminate\Filesystem\Filesystem;

class ApiController extends Controller
{
    public function data(ChannelProcessor $processor)
    {
        $userChannel = $processor->process(resource_path('data/user-channel.txt'));
        $customerChannel = $processor->process(resource_path('data/customer-channel.txt'));

        $stats = new DialogueStats($userChannel, $customerChannel);
        return [
            "longest_user_monologue" => $stats->getUserLongestMonologue(),
            "longest_customer_monologue" => $stats->getCustomerLongestMonologue(),
            "user_talk_percentage" => $stats->getUserMonologuePercent(),
            "user" => $userChannel->getMonologue(),
            "customer" => $customerChannel->getMonologue()
        ];

    }
    public function sdata( Filesystem $filesystem)
    {

        $monologue = [];

        // by definition we start from 0
        $segment = [0];
        foreach ($filesystem->lines(resource_path('data/customer-channel.txt')) as $line) {
            $chars = preg_split('/\[.*\]/i', $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $output = trim(current($chars));
            if(empty($output)){
                continue;
            }
             preg_match_all('/(silence_start|silence_end):\s([+-]?([0-9]*[.])?[0-9]+)/', $output, $matches);
            $matches = array_map(function ($match) {
                return current($match);
            }, $matches);
            list($match, $command, $timestamp) = $matches;


            if($command === 'silence_start') {
                $segment[] = (float)$timestamp;
                $monologue[] = $segment;
            }

            if($command === 'silence_end'){
                $segment = [(float)$timestamp];
            }
        }

        $longestMonologue = 0;
        $monologueTime = 0;
        foreach ($monologue as $segment){
            list($start, $end) = $segment;

            $segmentTalkTime = $end - $start;
            if($longestMonologue < $segmentTalkTime) {
                $longestMonologue = $segmentTalkTime;
            }
            $monologueTime += $segmentTalkTime;
        }

        $monologueEndTime = last(last($monologue));
        $monologuePercent = ($monologueTime / $monologueEndTime) * 100;
        dump($longestMonologue, $monologueTime, $monologueEndTime, round($monologuePercent, 2) );

    }
}
