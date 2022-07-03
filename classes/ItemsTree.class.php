<?php

require_once __DIR__ . '/Item.class.php';

class ItemsTree
{
    public $rootItem = null;

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
}