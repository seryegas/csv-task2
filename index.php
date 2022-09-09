<?php

require_once __DIR__ . '/autoloader.php';

if (!empty($argv[1]) && !empty($argv[2])) {
    $inputPath = $argv[1];
    $outputPath = $argv[2];

    (new CsvToJsonTreesConverter)->generateJsonTreeFromCsvFile($inputPath, $outputPath);
} else {
    print_r("Не переданы аргументы\n");
}
