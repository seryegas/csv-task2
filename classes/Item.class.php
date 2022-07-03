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

    function AddChild(Item $child)
    {
        $this->children[] = $child;
    }

    public static function FindItemByName(Item $item, $name)
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
                    $item = self::FindItemByName($child, $name);
                    if ($item->itemName === $name)
                    {
                        break;
                    }
                }
            }
            return $item;
        }
    }
}