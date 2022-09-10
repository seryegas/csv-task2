<?php

namespace classes;

class Item implements \JsonSerializable
{
    private $name;
    private $type;
    private $parent;
    private $relation;
    private $children;
    private $trigger;

    function __construct($name, $type, $parent, $relation = null, $children = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
        $this->relation = $relation;
        $this->children = $children;
        $this->trigger = 0;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
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
        if ($item->name === $name)
        {
            return $item;
        }
        else
        {
            if (count($item->children) > 0)
            {
                foreach ($item->children as $child)
                {
                    if ($item->name === $name)
                    {
                        break;
                    }
                    $item = self::FindItemByName($child, $name);
                }
            }
            return $item;
        }
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of parent
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @return  self
     */ 
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the value of relation
     */ 
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set the value of relation
     *
     * @return  self
     */ 
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get the value of trigger
     */ 
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * Set the value of trigger
     *
     * @return  self
     */ 
    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;

        return $this;
    }

    /**
     * Get the value of children
     */ 
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the value of children
     *
     * @return  self
     */ 
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }
}