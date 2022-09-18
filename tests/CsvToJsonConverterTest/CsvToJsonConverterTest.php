<?php

namespace CsvToJsonConverterTest;

use DataConverter\CsvToJsonTreesConverter;
use UnitTest;

class CsvToJsonConverterTest extends UnitTest
{
    private $testable;

    public function testCsvToJsonConverter()
    {
        (new CsvToJsonTreesConverter('test.csv', 'test.json'))->generateJsonTreeFromCsvFile();
    }
}