<?php

require_once 'vendor/autoload.php';

use SmartTest\FileHandler;
use SmartTest\DataHandler;
use SmartTest\OutputHandler;
use SmartTest\ArgsHandler;
use SmartTest\UniqueHandler;

$args_handler = new ArgsHandler($argv);

$filename = $args_handler->validateArgs();
$file_handler = new FileHandler($filename);
$extracted_data = $file_handler->getData();

$data_handler = new DataHandler();
$result['all'] = $data_handler->countArray($extracted_data);
$unique_handler = new UniqueHandler($extracted_data);
$unique_data = $unique_handler->getUnique();
$result['unique'] = $data_handler->countArray($unique_data);

foreach ($result as $item) {
    arsort($item);
}

$output = new OutputHandler($result);
$output->displayResult();
