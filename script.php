<?php

require_once( 'classes/FileHandler.php' );
require_once( 'classes/DataHandler.php' );
require_once( 'classes/OutputHandler.php' );

$file = new FileHandler( $argv );
$extracted_data = $file->getData();
$data = new DataHandler( $extracted_data );
$result = $data->getStats();
$output = new OutputHandler( $result );
$output->displayResult();
