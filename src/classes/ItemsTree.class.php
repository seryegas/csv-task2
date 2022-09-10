<?php

namespace classes;


class ItemsTree
{
    private $rootItem = null;

    function __construct()
    {
        $this->rootItem = new Item(
            null,
            null,
            null,
            null,
            []
        );
    }

    public function getRootItem()
    {
        return $this->rootItem;
    }
}
