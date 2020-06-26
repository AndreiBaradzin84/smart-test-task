<?php

namespace SmartTest;

class UniqueHandler
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getUnique(): array
    {
        return array_map("unserialize", array_unique(array_map("serialize", $this->data)));
    }
}
