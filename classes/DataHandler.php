<?php

namespace SmartTest;

class DataHandler
{

    public function countArray($data): array
    {
        $result_array = [];

        foreach ($data as $single_entry) {
            if ( ! array_key_exists($single_entry[0], $result_array)) {
                $result_array[$single_entry[0]] = 1;
                continue;
            }
            $result_array[$single_entry[0]]++;
        }

        return $result_array;
    }
}
