<?php

require_once __DIR__ . '/classes/WorkWithCsvFile.class.php';
require_once __DIR__ . '/classes/Item.class.php';
require_once __DIR__ . '/classes/ItemsTree.class.php';

$inputPath = $argv[1];
$outputPath = $argv[2];

$array = WorkWithCsvFile::ConvertCsvDataToPhpArray($inputPath);
unset($array[0]);
$arrayO = WorkWithCsvFile::FindNameOfRelationableElements($array, 'relation');
$tree = WorkWithCsvFile::MakeStructureTreeFromArray($array);
$helpingArray = WorkWithCsvFile::FillHelpingArrayByElements($tree, $arrayO);

$item = Item::FindItemByName($tree, 'Тележка Б25');
WorkWithCsvFile::MakingTreeFullByAddingSubtreesOfRelationableElements($tree, $helpingArray);
WorkWithCsvFile::RemoveSpareFields($tree);
file_put_contents($outputPath, json_encode($tree->children, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));



