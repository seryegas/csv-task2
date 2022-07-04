<?php

require_once __DIR__ . '/classes/WorkWithCsvFile.class.php';
require_once __DIR__ . '/classes/Item.class.php';
require_once __DIR__ . '/classes/ItemsTree.class.php';
require_once __DIR__ . '/tests/FileTesting.class.php';



if (!empty($argv[1]) && !empty($argv[2]))
{
    $inputPath = $argv[1];
    $outputPath = $argv[2];
    
    $arrayData = WorkWithCsvFile::ConvertCsvDataToPhpArray($inputPath);
    $arrayWithHelpingData = WorkWithCsvFile::FindNameOfRelationableElements($arrayData, 'relation');
    $tree = WorkWithCsvFile::MakeStructureTreeFromArray($arrayData);
    $helpingArray = WorkWithCsvFile::FillHelpingArrayByElements($tree, $arrayWithHelpingData);
    
    WorkWithCsvFile::MakingTreeFullByAddingSubtreesOfRelationableElements($tree, $helpingArray);
    WorkWithCsvFile::RemoveSpareFields($tree);
    FileTesting::StartAllTests();
    file_put_contents($outputPath, json_encode($tree->children, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
else
{
    print_r("Не переданы аргументы\n");
}




