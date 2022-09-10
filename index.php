<?php

use classes\CsvToJsonTreesConverter;
use tests\FileTesting;

require_once __DIR__ . '/autoloader.php';

if (!empty($argv[1]) && !empty($argv[2])) {
    $inputPath = $argv[1];
    $outputPath = $argv[2];

    (new FileTesting)->startTests();
    (new CsvToJsonTreesConverter)->generateJsonTreeFromCsvFile($inputPath, $outputPath);
} else {
    print_r("Не переданы аргументы\n");
}
