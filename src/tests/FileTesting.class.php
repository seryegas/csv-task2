<?php

namespace tests;

use classes\CsvToJsonTreesConverter;

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
        // self::CheckHelpingFunction();
        // self::CheckHelpingArrayWithElementsFunction();
        // self::CheckFillingTreeFromArrayFunction();
        // self::CheckMakingTreeFullByAddingSubtreesOfRelationableElementsFunction();
    }

    private function testReadCsvFile(): void
    {
        $array = $this->getCsvDataInPhpArray();
        $this->testable->readCsvFile('test.csv');
        $this->assertEquals($array, $this->testable->getCsvData());
    }

    private function testFindNameOfRelationableElements(): void
    {
        $array = ["4"];
        $arrayAfterFunction = $this->testable->findNameOfRelationableElements();
        $this->assertEquals($array, $arrayAfterFunction);       
    }

    

    // private function CheckHelpingArrayWithElementsFunction(): void
    // {
    //     $tree = new ItemsTree();
    //     $tree->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
    //     $tree->rootItem->AddChild(new Item("4", "Изделия и компоненты", "", "")); // 1
    //     $tree->rootItem->children[0]->AddChild(new Item("2", "Прямые компоненты", "1", "4")); // 0 0 
    //     $tree->rootItem->children[0]->AddChild(new Item("3", "Прямые компоненты", "1", "4")); // 0 1
    //     $tree->rootItem->children[1]->AddChild(new Item("6", "Изделия и компоненты", "5", "")); // 1 0 0

    //     $helpingArray = ["4"];
    //     $array = ["4" => $tree->rootItem->children[1]];

    //     $arrayAfterFunction = WorkWithCsvFile::FillHelpingArrayByElements($tree->rootItem, $helpingArray);
        
    //     if ($array === $arrayAfterFunction)
    //     {
    //         print_r("Выполнено успешно 3 тест\n");
    //     }
    //     else
    //     {
    //         print_r("Тест 3 провален\n");
    //     }
    // }

    // private function CheckFillingTreeFromArrayFunction(): void
    // {
    //     $tree = new ItemsTree();
    //     $tree->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
    //     $tree->rootItem->children[0]->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
    //     $tree->rootItem->children[0]->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
    //     $tree->rootItem->children[0]->AddChild(new Item("4", "Изделия и компоненты", "1", "")); // 1

    //     $arrayFilled = [
    //         1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
    //         2 => ["itemName" => "2", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
    //         3 => ["itemName" => "3", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
    //         4 => ["itemName" => "4", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""]
    //     ];
        
    //     $rootItemAfterFunction = WorkWithCsvFile::MakeStructureTreeFromArray($arrayFilled);
    //     if ($tree->rootItem == $rootItemAfterFunction)
    //     {
    //         print_r("Выполнено успешно 4 тест\n");
    //     }
    //     else
    //     {
    //         print_r("Тест 4 провален\n");
    //     }
    // }
   // 1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
    // private function CheckMakingTreeFullByAddingSubtreesOfRelationableElementsFunction(): void
    // {
    //     $tree = new ItemsTree();
    //     $tree->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
    //     $tree->rootItem->children[0]->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
    //     $tree->rootItem->children[0]->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
    //     $tree->rootItem->children[0]->AddChild(new Item("4", "Прямые компоненты", "1", "2")); // 1
    //     $tree->rootItem->children[0]->children[0]->AddChild(new Item("5", "Изделия и компоненты", "2", ""));
    //     $tree->rootItem->children[0]->children[0]->AddChild(new Item("6", "Изделия и компоненты", "2", ""));

    //     $helpingArray = [
    //         "2" => $tree->rootItem->children[0]->children[0]
    //     ];

    //     $treeFilled = new ItemsTree();
    //     $treeFilled->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
    //     $treeFilled->rootItem->children[0]->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
    //     $treeFilled->rootItem->children[0]->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
    //     $treeFilled->rootItem->children[0]->AddChild(new Item("4", "Прямые компоненты", "1", "2")); // 1
    //     $treeFilled->rootItem->children[0]->children[0]->AddChild(new Item("5", "Изделия и компоненты", "2", ""));
    //     $treeFilled->rootItem->children[0]->children[0]->AddChild(new Item("6", "Изделия и компоненты", "2", ""));
    //     $treeFilled->rootItem->children[0]->children[2]->AddChild(new Item("5", "Изделия и компоненты", "2", ""));
    //     $treeFilled->rootItem->children[0]->children[2]->AddChild(new Item("6", "Изделия и компоненты", "2", ""));
    //     $treeFilled->rootItem->children[0]->children[2]->trigger = 1;
        
    //     WorkWithCsvFile::MakingTreeFullByAddingSubtreesOfRelationableElements(
    //         $tree->rootItem, $helpingArray);

    //     if ($treeFilled->rootItem == $tree->rootItem)
    //     {
    //         print_r("Выполнено успешно 5 тест\n");
    //     }
    //     else
    //     {
    //         print_r("Тест 5 провален\n");
    //     }
    // }

    public function getCsvDataInPhpArray()
    {
        return [
            1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
            2 => ["itemName" => "2", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
            3 => ["itemName" => "3", "type" => "Изделия и компоненты", "parent" => "1", "relation" => "4"],
            4 => ["itemName" => "4", "type" => "Изделия и компоненты", "parent" => "1", "relation" => "4"]
        ];
    }
}