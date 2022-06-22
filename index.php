<?php

var_dump(__DIR__ . '/classes/WorkWithCsvFile.class.php');

require_once __DIR__ . '/classes/WorkWithCsvFile.class.php';

$inputPath = $argv[1];
$outputPath = $argv[2];

$array = WorkWithCsvFile::ConvertCsvDataToPhpArray($inputPath);

var_dump($array);