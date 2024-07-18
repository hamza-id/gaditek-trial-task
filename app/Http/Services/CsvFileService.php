<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;
use Exception;

class CsvFileService
{
    public function getCsvContent($csv, $sortBy)
    {
        $fileContents = file($csv->getPathname());
        if (!$fileContents || count($fileContents) <= 1) {
            throw new Exception('Empty or invalid CSV file!');
        }
        $headers = $this->getHeaders(head($fileContents));
        $csvData = $this->parseCsvData($fileContents, $headers);
        $sortBy  = $this->verifySortByColumn($headers, $sortBy);
        return $csvData->sortBy($sortBy)->values();
    }

    protected function getHeaders($headerLine)
    {
        return array_map('trim', str_getcsv($headerLine));
    }

    protected function verifySortByColumn($headers, $sortBy)
    {
        if(!in_array($sortBy, $headers))
        {
            $sortBy = config('constant.default_sort_column');
        }
        return $sortBy;
    }

    protected function parseCsvData($lines, $headers)
    {
        $data = collect();

        foreach ($lines as $line) {
            $values    = str_getcsv($line);
            $csvRecord = array_combine($headers, array_map('trim', $values));
            $data->push($csvRecord);
        }
        return $data;
    }

    public function createCsv($filename, $contents)
    {
        $path = config('constant.csv_path');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true);
        }

        $filePath = $path . $filename;
        $file     = fopen($filePath, 'w');

        if ($contents->isNotEmpty()) {
            fputcsv($file, array_keys($contents->first()));
            foreach ($contents as $data) {
                fputcsv($file, $data);
            }
        }

        fclose($file);
        return $filePath;
    }
}
