<?php

namespace classes;

use Exception;

class CsvToJsonTreesConverter
{

    private $csvData;
    private $treeRoot;
    private $helpingArray;

    public function __construct()
    {
        $this->csvData = [];
        $this->treeRoot = (new ItemsTree)->getRootItem();
        $this->helpingArray = [];
    }

    public function generateJsonTreeFromCsvFile(string $inputPath, string $outputPath): void
    {
        try {
            $this->readCsvFile($inputPath);
            $this->makeStructureTreeFromArray();
            $this->completeHelpingArray();

            $this->MakingTreeFullByAddingSubtreesOfRelationableElements($this->treeRoot);
            $this->RemoveSpareFields($this->treeRoot);

            file_put_contents($outputPath, json_encode(
                $this->treeRoot->getChildren(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ));
        } catch (Exception $e) {
            echo 'Something went wrong: ' . $e->getMessage();
        }
    }

    public function readCsvFile(string $inputPath): void
    {
        $data = [];
        if (file_exists($inputPath) && (($file = fopen($inputPath, 'r')) != false)) {
            while ($fileData = fgetcsv($file, 20000, ';')) {
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
        } else {
            echo "Problems with file!\n";
        }
        $this->csvData = $data;
    }

    public function completeHelpingArray()
    {
        $arrayWithHelpingData = $this->FindNameOfRelationableElements();
        $this->FillHelpingArrayByElements($arrayWithHelpingData);
    }

    // нахождение возmожных продолжений для прямых компонентов
    public function findNameOfRelationableElements(): array
    {
        $arrayWithNamesOfElements = [];

        foreach ($this->csvData as $line) {
            if (!empty($line['relation'])) {
                $arrayWithNamesOfElements[] = $line['relation'];
            }
        }

        return array_unique($arrayWithNamesOfElements);
    }

    public function fillHelpingArrayByElements(array $helpingArray): void
    {
        $helpingArrayFilled = [];

        foreach ($helpingArray as $name) {
            $item = Item::FindItemByName($this->treeRoot, $name);
            $helpingArrayFilled[$item->getName()] = $item;
        }

        $this->helpingArray = $helpingArrayFilled;
    }

    public function makeStructureTreeFromArray(): void
    {
        foreach ($this->csvData as $line) {
            $item = $this->convertDataFromLineToItem($line);
            if (empty($line['parent'])) {
                $this->treeRoot->AddChild($item);
            } else {
                $parent = Item::FindItemByName($this->treeRoot, $line['parent']);
                $parent->AddChild($item);
            }
        }
    }

    public function MakingTreeFullByAddingSubtreesOfRelationableElements(Item $item): void
    {
        if (
            $item->getType() === "Прямые компоненты" &&
            count($this->helpingArray[$item->getRelation()]->getChildren()) > 0 &&
            $item->getTrigger() === 0
        ) {
            $item->setChildren(array_merge($this->helpingArray[$item->getRelation()]->getChildren(), $item->getChildren()));
            $item->setTrigger(1);
        }

        if (count($item->getChildren()) > 0) {
            foreach ($item->getChildren() as $child) {
                $item = self::MakingTreeFullByAddingSubtreesOfRelationableElements($child);
            }
        }
    }

    public function RemoveSpareFields(Item $item): void
    {
        if ($item != null) {
            $item->RemoveFields();
        }
        if (count($item->getChildren()) > 0) {
            foreach ($item->getChildren() as $child) {
                $item = self::RemoveSpareFields($child);
            }
        }
    }

    public function convertDataFromLineToItem(array $line): Item
    {
        return new Item(
            $line['itemName'],
            $line['type'],
            $line['parent'],
            $line['relation'],
            []
        );
    }

    public function getCsvData()
    {
        return $this->csvData;
    }

    public function getTreeRoot()
    {
        return $this->treeRoot;
    }

    public function getHelpingArray()
    {
        return $this->helpingArray;
    }
}
