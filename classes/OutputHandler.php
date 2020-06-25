<?php

namespace SmartTest;

class OutputHandler
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function displayResult()
    {

        foreach ($this->data as $type => $data) {
            echo "\nTop page visits - " . $type . "\n\n";

            foreach ($data as $page => $visits) {
                echo $page . ' visited ' . $visits . " times\n";
            }

        }
    }
}
