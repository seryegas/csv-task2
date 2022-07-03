<?php

class Item
{
    public $itemName = null;
    public $type = null;
    public $parent = null;
    public $relation = null;
    public $children = [];
    public $trigger = 0;

    function __construct($itemName, $type, $parent, $relation = null, $children = [])
    {
        $this->itemName = $itemName;
        $this->type = $type;
        $this->parent = $parent;
        $this->relation = $relation;
        $this->children = $children;
        $this->trigger = 0;
    }

    public function AddChild(Item $child): void 
    {
        $this->children[] = $child;
    }

    public function RemoveFields()
    {
        unset($this->trigger);
        unset($this->relation);
        unset($this->type);
    }

    public static function FindItemByName(Item $item, $name): Item
    {
        if ($item->itemName === $name)
        {
            return $item;
        }
        else
        {
            if (count($item->children) > 0)
            {
                foreach ($item->children as $child)
                {
                    if ($item->itemName === $name)
                    {
                        break;
                    }
                    $item = self::FindItemByName($child, $name);
                }
            }
            return $item;
        }
    }
}