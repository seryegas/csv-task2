<?php

require_once __DIR__ . '/classes/WorkWithCsvFile.class.php';
require_once __DIR__ . '/classes/Item.class.php';
require_once __DIR__ . '/classes/ItemsTree.class.php';
require_once __DIR__ . '/tests/FileTesting.class.php';


$inputPath = $argv[1];
$outputPath = $argv[2];

$array = WorkWithCsvFile::ConvertCsvDataToPhpArray($inputPath);
$arrayO = WorkWithCsvFile::FindNameOfRelationableElements($array, 'relation');
$tree = WorkWithCsvFile::MakeStructureTreeFromArray($array);
$helpingArray = WorkWithCsvFile::FillHelpingArrayByElements($tree, $arrayO);

WorkWithCsvFile::MakingTreeFullByAddingSubtreesOfRelationableElements($tree, $helpingArray);
WorkWithCsvFile::RemoveSpareFields($tree);
FileTesting::StartAllTests();
file_put_contents($outputPath, json_encode($tree->children, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));



