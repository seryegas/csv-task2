<?php

require_once __DIR__ . '/../classes/WorkWithCsvFile.class.php';
require_once __DIR__ . '/../classes/ItemsTree.class.php';
require_once __DIR__ . '/../tests/FileTesting.class.php';

class FileTesting
{
    private function CheckOpenFunction(): void
    {
        $array = [
            1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
            2 => ["itemName" => "2", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
            3 => ["itemName" => "3", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
            4 => ["itemName" => "4", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""]
        ];
        $arrayAfterFunction = WorkWithCsvFile::ConvertCsvDataToPhpArray('test.csv');

        if ($array === $arrayAfterFunction)
        {
            print_r("Выполнено успешно 1 тест\n");
        }
        else
        {
            print_r("Тест 1 провален\n");
        }
    }

    private function CheckHelpingFunction(): void
    {
        $arrayFilled = [
            1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
            2 => ["itemName" => "4", "type" => "Прямые компоненты", "parent" => "1", "relation" => ""],
            3 => ["itemName" => "3", "type" => "Изделия и компоненты", "parent" => "1", "relation" => "4"],
            4 => ["itemName" => "4", "type" => "Изделия и компоненты", "parent" => "1", "relation" => "4"]
        ];

        $array = ["4"];

        $type = 'relation';
        $arrayAfterFunction = WorkWithCsvFile::FindNameOfRelationableElements($arrayFilled, $type);

        if ($array === $arrayAfterFunction)
        {
            print_r("Выполнено успешно 2 тест\n");
        }
        else
        {
            print_r("Тест 2 провален\n");
        }
        
    }

    private function CheckHelpingArrayWithElementsFunction(): void
    {
        $tree = new ItemsTree();
        $tree->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
        $tree->rootItem->AddChild(new Item("4", "Изделия и компоненты", "", "")); // 1
        $tree->rootItem->children[0]->AddChild(new Item("2", "Прямые компоненты", "1", "4")); // 0 0 
        $tree->rootItem->children[0]->AddChild(new Item("3", "Прямые компоненты", "1", "4")); // 0 1
        $tree->rootItem->children[1]->AddChild(new Item("6", "Изделия и компоненты", "5", "")); // 1 0 0

        $helpingArray = ["4"];
        $array = ["4" => $tree->rootItem->children[1]];

        $arrayAfterFunction = WorkWithCsvFile::FillHelpingArrayByElements($tree->rootItem, $helpingArray);
        
        if ($array === $arrayAfterFunction)
        {
            print_r("Выполнено успешно 3 тест\n");
        }
        else
        {
            print_r("Тест 3 провален\n");
        }
    }

    private function CheckFillingTreeFromArrayFunction(): void
    {
        $tree = new ItemsTree();
        $tree->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
        $tree->rootItem->children[0]->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
        $tree->rootItem->children[0]->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
        $tree->rootItem->children[0]->AddChild(new Item("4", "Изделия и компоненты", "1", "")); // 1

        $arrayFilled = [
            1 => ["itemName" => "1", "type" => "Изделия и компоненты", "parent" => "", "relation" => ""],
            2 => ["itemName" => "2", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
            3 => ["itemName" => "3", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""],
            4 => ["itemName" => "4", "type" => "Изделия и компоненты", "parent" => "1", "relation" => ""]
        ];
        
        $rootItemAfterFunction = WorkWithCsvFile::MakeStructureTreeFromArray($arrayFilled);
        if ($tree->rootItem == $rootItemAfterFunction)
        {
            print_r("Выполнено успешно 4 тест\n");
        }
        else
        {
            print_r("Тест 4 провален\n");
        }
    }

    private function CheckMakingTreeFullByAddingSubtreesOfRelationableElementsFunction(): void
    {
        $tree = new ItemsTree();
        $tree->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
        $tree->rootItem->children[0]->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
        $tree->rootItem->children[0]->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
        $tree->rootItem->children[0]->AddChild(new Item("4", "Прямые компоненты", "1", "2")); // 1
        $tree->rootItem->children[0]->children[0]->AddChild(new Item("5", "Изделия и компоненты", "2", ""));
        $tree->rootItem->children[0]->children[0]->AddChild(new Item("6", "Изделия и компоненты", "2", ""));

        $helpingArray = [
            "2" => $tree->rootItem->children[0]->children[0]
        ];

        $treeFilled = new ItemsTree();
        $treeFilled->rootItem->AddChild(new Item("1", "Изделия и компоненты", "", "")); // 0 
        $treeFilled->rootItem->children[0]->AddChild(new Item("2", "Изделия и компоненты", "1", "")); // 1
        $treeFilled->rootItem->children[0]->AddChild(new Item("3", "Изделия и компоненты", "1", "")); // 1
        $treeFilled->rootItem->children[0]->AddChild(new Item("4", "Прямые компоненты", "1", "2")); // 1
        $treeFilled->rootItem->children[0]->children[0]->AddChild(new Item("5", "Изделия и компоненты", "2", ""));
        $treeFilled->rootItem->children[0]->children[0]->AddChild(new Item("6", "Изделия и компоненты", "2", ""));
        $treeFilled->rootItem->children[0]->children[2]->AddChild(new Item("5", "Изделия и компоненты", "2", ""));
        $treeFilled->rootItem->children[0]->children[2]->AddChild(new Item("6", "Изделия и компоненты", "2", ""));
        $treeFilled->rootItem->children[0]->children[2]->trigger = 1;
        
        WorkWithCsvFile::MakingTreeFullByAddingSubtreesOfRelationableElements(
            $tree->rootItem, $helpingArray);

        if ($treeFilled->rootItem == $tree->rootItem)
        {
            print_r("Выполнено успешно 5 тест\n");
        }
        else
        {
            print_r("Тест 5 провален\n");
        }
    }

    public static function StartAllTests()
    {
        self::CheckOpenFunction();
        self::CheckHelpingFunction();
        self::CheckHelpingArrayWithElementsFunction();
        self::CheckFillingTreeFromArrayFunction();
        self::CheckMakingTreeFullByAddingSubtreesOfRelationableElementsFunction();
    }
}