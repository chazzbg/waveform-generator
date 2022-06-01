<?php

namespace App\Services;

use App\Services\Data\Channel;

class DialogueStats
{
    private $totalTalkTime = 0;
    private $userMonologueTime = 0;
    private $userLongestMonologue = 0;
    private $userMonologueEndTime = 0;
    private $userMonologuePercent = 0;
    private $customerMonologueTime = 0;
    private $customerLongestMonologue = 0;
    private $customerMonologueEndTime = 0;
    private $customerMonologuePercent = 0;


    public function __construct(private Channel $user, private Channel $customer)
    {
        $this->userMonologueEndTime = $this->user->getEndTime();
        $this->customerMonologueEndTime = $this->customer->getEndTime();
        $this->totalTalkTime = max($this->userMonologueEndTime, $this->customerMonologueEndTime);

        $this->userMonologueTime = $this->calcLongestMonologueTime($this->user);
        $this->customerMonologueTime = $this->calcLongestMonologueTime($this->customer);

        $this->userLongestMonologue = $this->calcLongestMonologueTime($this->user);
        $this->customerLongestMonologue = $this->calcLongestMonologueTime($this->customer);

        $this->userMonologuePercent = round(($this->userMonologueTime / $this->totalTalkTime) * 100, 2);
        $this->customerMonologuePercent = round (($this->customerMonologueTime / $this->totalTalkTime) * 100, 2);
    }

    private function calcLongestMonologueTime(Channel $channel)
    {
        $monologueTime = 0;
        foreach ($channel->getMonologue() as $segment){
            list($start, $end) = $segment;

            $segmentTalkTime = $end - $start;

            $monologueTime += $segmentTalkTime;
        }
        return $monologueTime;
    }

    private function calcLongestMonologueSegment(Channel $channel)
    {
        $longestMonologue = 0;
        foreach ($channel->getMonologue() as $segment){
            list($start, $end) = $segment;

            $segmentTalkTime = $end - $start;

            if($longestMonologue < $segmentTalkTime) {
                $longestMonologue = $segmentTalkTime;
            }
        }
        return $longestMonologue;
    }

    /**
     * @return int
     */
    public function getTotalTalkTime(): int
    {
        return $this->totalTalkTime;
    }

    /**
     * @return int
     */
    public function getUserMonologueTime(): int
    {
        return $this->userMonologueTime;
    }

    /**
     * @return int
     */
    public function getUserLongestMonologue(): int
    {
        return $this->userLongestMonologue;
    }

    /**
     * @return int
     */
    public function getUserMonologueEndTime(): int
    {
        return $this->userMonologueEndTime;
    }

    /**
     * @return int
     */
    public function getUserMonologuePercent(): int
    {
        return $this->userMonologuePercent;
    }

    /**
     * @return int
     */
    public function getCustomerMonologueTime(): int
    {
        return $this->customerMonologueTime;
    }

    /**
     * @return int
     */
    public function getCustomerLongestMonologue(): int
    {
        return $this->customerLongestMonologue;
    }

    /**
     * @return int
     */
    public function getCustomerMonologueEndTime(): int
    {
        return $this->customerMonologueEndTime;
    }

    /**
     * @return int
     */
    public function getCustomerMonologuePercent(): int
    {
        return $this->customerMonologuePercent;
    }





}
