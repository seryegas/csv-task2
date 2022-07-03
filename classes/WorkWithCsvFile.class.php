<?php

require_once __DIR__ . '/Item.class.php';
require_once __DIR__ . '/ItemsTree.class.php';

class WorkWithCsvFile
{
    public static function ConvertCsvDataToPhpArray(string $inputPath): array
    {
        $data= [];
        if (($file = fopen($inputPath, 'r')) !== false)
        {
            while ($fileData = fgetcsv($file, 20000, ';'))
            {
                $data[] = 
                [
                    "itemName" => $fileData[0],
                    "type" => $fileData[1],
                    "parent" => $fileData[2],
                    "relation" => $fileData[3],
                ];
            }
            unset($data[0]);
            fclose($file);
        }
        else
        {
            print_r("Проблемы с размером файла\n");
        }
        return $data;   
    }

    // нахождение возиожных продолжений для прямых компонентов
    public static function FindNameOfRelationableElements(array $array, string $type): array
    {
        $arrayWithNamesOfElements = [];
        foreach($array as $line)
        {
            if (!empty($line[$type]))
            {
                $arrayWithNamesOfElements[] = $line[$type];
            }
        }
        $arrayWithNamesOfElements = array_unique($arrayWithNamesOfElements);

        return $arrayWithNamesOfElements;
    }

    public static function FillHelpingArrayByElements(Item $root, array $helpingArray): array
    {
        $newArray = [];
        foreach ($helpingArray as $name)
        {
            $item = Item::FindItemByName($root, $name);
            $newArray[$item->itemName] = $item;
        }
        
        return $newArray;
    }

    public static function MakeStructureTreeFromArray(array $array): Item
    {
        $itemsList = new ItemsTree();
        $rootItem = $itemsList->rootItem;
        foreach ($array as $line)
        {
            $item = self::ConvertDataFromLineToItem($line);
            if (empty($line['parent']))
            {
                $rootItem->AddChild($item);
            }
            else
            {
                $parent = Item::FindItemByName($rootItem, $line['parent']);
                $parent->AddChild($item);
            }
        }
        return $rootItem;
    }

    public static function MakingTreeFullByAddingSubtreesOfRelationableElements(Item $item, 
        array $helpingArray): void
    {
        if ($item->type === "Прямые компоненты" && 
            count($helpingArray[$item->relation]->children) > 0 &&
            $item->trigger === 0)
        {
            $item->children = array_merge($helpingArray[$item->relation]->children, $item->children);
            $item->trigger = 1;
        }
            
        if (count($item->children) > 0)
        {
            foreach ($item->children as $child)
            {
                $item = self::MakingTreeFullByAddingSubtreesOfRelationableElements($child, $helpingArray);
            }
        }
    }
    
    public static function RemoveSpareFields(Item $item): void
    {
        if ($item != null)
        {
            $item->RemoveFields();
        }
        if (count($item->children) > 0)
        {
            foreach ($item->children as $child)
            {
                $item = self::RemoveSpareFields($child);
            }
        }
    }

    public static function ConvertDataFromLineToItem(array $line): Item
    {
        return new Item(
            $line['itemName'],
            $line['type'],
            $line['parent'],
            $line['relation'],
            []
        );
    }

    
}