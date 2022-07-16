<?php

require_once __DIR__ . '/classes/WorkWithCsvFile.class.php';
require_once __DIR__ . '/classes/Item.class.php';
require_once __DIR__ . '/classes/ItemsTree.class.php';
require_once __DIR__ . '/tests/FileTesting.class.php';



if (!empty($argv[1]) && !empty($argv[2]))
{
    $inputPath = $argv[1];
    $outputPath = $argv[2];
    
    FileTesting::StartAllTests();
    WorkWithCsvFile::GenerateJsonTreeFromCsvFile($inputPath, $outputPath);
}
else
{
    print_r("Не переданы аргументы\n");
}




