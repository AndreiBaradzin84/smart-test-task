<?php

require_once 'vendor/autoload.php';

use SmartTest\FileHandler;
use SmartTest\DataHandler;
use SmartTest\OutputHandler;

$file = new FileHandler($argv);
$extracted_data = $file->getData();
$data = new DataHandler($extracted_data);
$result = $data->getStats();
$output = new OutputHandler($result);
$output->displayResult();
