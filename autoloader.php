<?php

spl_autoload_register( function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once __DIR__ . '/src/classes/' . $class . '.class.php';
});