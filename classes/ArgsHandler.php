<?php

namespace SmartTest;

class ArgsHandler
{
    private $args;

    public function __construct(array $args)
    {
        $this->args = $args;
    }

    public function validateArgs(): string
    {
        if ( ! array_key_exists(1, $this->args) || empty($this->args[1])) {
            throw new FileHandlerException('No file provided');
        }

        if ( ! file_exists($this->args[1])) {
            throw new FileHandlerException($this->args[1] . ' file not exists');
        }

        return $this->args[1];
    }
}
