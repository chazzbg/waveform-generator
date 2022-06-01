<?php

namespace App\Services;


use Illuminate\Filesystem\Filesystem;

class FileDataReader
{

    public function __construct(private Filesystem $filesystem)
    {
    }

    public function read($filename)
    {
        $data = [];
        foreach ($this->filesystem->lines($filename) as $line) {
            $chars = preg_split('/\[.*\]/i', $line, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $output = trim(current($chars));
            if (empty($output)) {
                continue;
            }
            preg_match_all('/(silence_start|silence_end):\s([+-]?([0-9]*[.])?[0-9]+)/', $output, $matches);
            $matches = array_map(function ($match) {
                return current($match);
            }, $matches);
            list($match, $command, $timestamp) = $matches;
            $data[] = compact('command', 'timestamp');
        }
        return $data;
    }
}
