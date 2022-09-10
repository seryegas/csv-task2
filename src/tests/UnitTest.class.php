<?php

namespace tests;

class UnitTest
{
    protected function assertEquals($expected, $actual)
    {
        if ($expected === $actual) {
            echo __FUNCTION__ . 'successfully completed';
        } else {
            echo __FUNCTION__ . 'failed';
        }
    }
}
