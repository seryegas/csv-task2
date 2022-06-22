<?php

class WorkWithCsvFile
{
    public static function ConvertCsvDataToPhpArray(string $inputPath): array
    {
        $data= [];
        if (($file = fopen($inputPath, 'r')) !== false)
        {
            while ($fileData = fgetcsv($file, 20000, ';'))
            {
                $data[] = $fileData;
                
            }
        }
        fclose($file);
        return $data;   
    }
}