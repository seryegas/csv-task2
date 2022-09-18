<?php

$start = microtime(true);

use DataConverter\CsvToJsonTreesConverter;
use CsvToJsonConverterTest\FileTesting;

require_once __DIR__ . '/autoloader.php';

if (!empty($argv[1]) && !empty($argv[2])) {
    $inputPath = $argv[1];
    $outputPath = $argv[2];

    //(new FileTesting)->startTests();
    (new CsvToJsonTreesConverter($inputPath, $outputPath))->generateJsonTreeFromCsvFile();
    echo "Successfully completed!\n";
} else {
    echo "No arguments put in function!\n";
}
 
echo "==========================================================\n";
echo "Время выполнения скрипта: " . (microtime(true) - $start) . " sec.\n";
echo "==========================================================\n";
