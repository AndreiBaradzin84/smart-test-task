<?php

namespace SmartTest;

class FileHandler
{

    private $file_handle;
    private $filename;

    public function __construct(array $args)
    {
        if ($this->validateArgs($args)) {
            $this->file_handle = fopen($this->filename, "r");
        }
    }

    public function getData(): array
    {
        $data_array = [];

        while ( ! feof($this->file_handle)) {

            $line = fscanf($this->file_handle, "%s %s");

            if ( ! is_array($line)) {
                continue;
            }

            if ( ! $this->checkDataPair($line)) {
                continue;
            }

            $data_array[] = $line;
        }

        if (empty($data_array)) {

            throw new FileHandlerException('No valid data in logfile');
        }

        return $data_array;
    }

    private function checkDataPair(array $pair): bool
    {
        // I can use filter_var($ip, FILTER_VALIDATE_IP) function but i think
        // that IP address in example log generated randomly w/o checking IP4 ruleset
        // and i should use regular expression instead
        if (empty($pair[1]) || ! preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $pair[1])) {

            return false;
        }

        return true;
    }

    private function validateArgs(array $args): bool
    {
        if ( ! array_key_exists(1, $args) || empty($args[1])) {
            throw new FileHandlerException('No file provided');
        }

        if ( ! file_exists($args[1])) {
            throw new FileHandlerException($args[1] . ' file not exists');
        }

        if ( ! $this->validateFileSize(filesize($args[1]))) {

            throw new FileHandlerException($args[1] . ' file too large');
        }

        $this->filename = $args[1];

        return true;
    }

    private function validateFileSize(int $filesize): bool
    {
        $memory_limit = ini_get('memory_limit');
        if ($memory_limit != -1) {

            preg_match("@[kmg]@i", $memory_limit, $letter);

            if ( ! empty($letter)) {

                $letter = strtolower($letter[0]);
                $memory_limit = (int)$memory_limit;
                switch ($letter) {
                    case 'k' :
                        {
                            $memory_limit = $memory_limit * 1024;
                            break;
                        }
                    case 'm' :
                        {
                            $memory_limit = $memory_limit * 1024 ** 2;
                            break;
                        }
                    case 'g' :
                        {
                            $memory_limit = $memory_limit * 1024 ** 3;
                            break;
                        }
                }
            }

            if ($filesize >= $memory_limit * 0.7) {
                return false;
            }

            return true;
        }
    }
}
