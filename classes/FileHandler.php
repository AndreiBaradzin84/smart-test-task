<?php

namespace SmartTest;

class FileHandler
{

    private $file_handle;
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if ( ! $this->validateFileSize(filesize($this->filename))) {
            throw new FileHandlerException($this->filename . ' file too large');
        }

        $this->file_handle = fopen($this->filename, "r");
    }

    public function __destruct()
    {
        fclose($this->file_handle);
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
