<?php

namespace DataConverter;

use Models\Item;
use Models\ItemsTree;
use Exception;
use Utils\ItemsConstants;
use Utils\FileConstants;

class CsvToJsonTreesConverter
{
    private $treeRoot;
    private $inputPath;
    private $outputPath;

    public function __construct(string $inputPath, string $outputPath)
    {
        $this->treeRoot = (new ItemsTree)->getRootItem();
        $this->inputPath = $inputPath;
        $this->outputPath = $outputPath;
    }

    public function generateJsonTreeFromCsvFile(): void
    {
        try {
            $this->readFileAndBuildTreeIfExists();
            $this->makingTreeFullByAddingSubtreesOfRelationableElements($this->treeRoot);
            $this->removeSpareFields($this->treeRoot);

            file_put_contents($this->outputPath, json_encode(
                $this->treeRoot->getChildren(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ));
        } catch (Exception $e) {
            echo 'Something went wrong: ' . $e->getMessage();
        }
    }

    public function readFileAndBuildTreeIfExists(): void
    {
        if (file_exists($this->inputPath) && (($file = fopen($this->inputPath, 'r')) != false)) {
            $this->readFileAndBuildTree($file);
        } else {
            echo "Problems with file!\n";
        }
    }

    public function readFileAndBuildTree($file): void
    {
        $this->skipFirstRow($file);
        while ($fileData = fgetcsv($file, FileConstants::ROW_LIMIT, FileConstants::PARAMETR_SEPARATOR)) {
            $this->addItemToTree($this->convertDataFromCsvLineToItem($fileData));
        }

        fclose($file);
    }

    public function skipFirstRow($file)
    {
        fgetcsv($file);
    }

    public function addItemToTree(Item $item): void
    {
        if (empty($item->getParent())) {
            $this->treeRoot->addChild($item);
        } else {
            $parent = $this->treeRoot->findItemByName($this->treeRoot, $item->getParent());
            $parent->addChild($item);
        }
    }

    public function makingTreeFullByAddingSubtreesOfRelationableElements(Item $item): void
    {
        if (
            $item->getType() === ItemsConstants::STRAIGHT_COMPONENTS &&
            $item->getTrigger() === 0
            ) {
            $this->fillStraightComponents($item);
        }

        if (count($item->getChildren()) > 0) {
            foreach ($item->getChildren() as $child) {
                $this->makingTreeFullByAddingSubtreesOfRelationableElements($child);
            }
        }
    }

    public function fillStraightComponents(Item $item) {
        $childrensToAdd = $this->treeRoot->findItemByName($this->treeRoot, $item->getRelation())->getChildren();
        if ($childrensToAdd) {
            $childrensAllreadyExists = $item->getChildren();;
            $item->setChildren(array_merge($childrensToAdd, $childrensAllreadyExists));
            $item->setTrigger(1);
        }     
    }

    public function removeSpareFields(Item $item): void
    {
        if ($item != null) {
            $item->removeFields();
        }
        if (count($item->getChildren()) > 0) {
            foreach ($item->getChildren() as $child) {
                $this->removeSpareFields($child);
            }
        }
    }

    public function convertDataFromCsvLineToItem(array $line): Item
    {
        return new Item(
            $line[ItemsConstants::ITEM_NAME],
            $line[ItemsConstants::ITEM_TYPE],
            $line[ItemsConstants::ITEM_PARENT],
            $line[ItemsConstants::ITEM_RELATION]
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
