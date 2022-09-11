<?php

namespace tests;

use classes\CsvToJsonTreesConverter;
use classes\Item;
use classes\ItemsTree;

class FileTesting extends UnitTest
{
    private $testable;

    public function __construct()
    {
        $this->testable = new CsvToJsonTreesConverter();
    }

    public function startTests()
    {
        $this->testReadCsvFile();
        $this->testFindNameOfRelationableElements();
        $this->testMakeStructureTreeFromArray();
    }

    private function testReadCsvFile(): void
    {
        $array = $this->getCsvDataInPhpArray();
        $this->testable->readCsvFile('test.csv');
        $this->assertEquals($array, $this->testable->getCsvData());
    }

    private function testMakeStructureTreeFromArray()
    {
        $tree = $this->getTreeWithoutContinues();
        $this->testable->MakeStructureTreeFromArray();
        var_dump($tree);var_dump($this->testable->getTreeRoot());
        $this->assertEquals($tree, $this->testable->getTreeRoot());
    }

    private function testFindNameOfRelationableElements(): void
    {
        $array = ["4"];
        $arrayAfterFunction = $this->testable->findNameOfRelationableElements();
        $this->assertEquals($array, $arrayAfterFunction);       
    }

    public function getCsvDataInPhpArray(): array
    {
        return [
            1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
            2 => ["itemName" => "2", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
            3 => ["itemName" => "3", "type" => "Изделия и компоненты", "parent" => "1", "relation" => "4"],
            4 => ["itemName" => "4", "type" => "Изделия и компоненты", "parent" => "1", "relation" => "4"]
        ];
    }

    public function getTreeWithoutContinues(): Item
    {
        $treeRoot = (new ItemsTree())->getRootItem();
        $treeRoot->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
        $treeRoot->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
        $treeRoot->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
        $treeRoot->AddChild(new Item("4", "Изделия и компоненты", "1", "")); // 1
        return $treeRoot;
    }
}