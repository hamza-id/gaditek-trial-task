<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Services\CsvFileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CsvFile;
use Exception;

class CsvFileController extends Controller
{
    protected $csvFileService;

    public function __construct(CsvFileService $csvFileService)
    {
        $this->csvFileService = $csvFileService;
    }

    public function showUploadForm()
    {
        return view('csv.upload');
    }

    public function uploadCsv(CsvFile $request)
    {
        try {
            $csv = $request->file('csv_file');
            $sortedData = $this->csvFileService->getCsvContent($csv, $request->sort_column ?? config('constant.default_sort_column'));
            $sortedFilePath = $this->csvFileService->createCsv('sorted_output_' . time() . '.csv', $sortedData);

            return redirect()->route('csv.upload')->with('success', 'CSV file created successfully at: ' . $sortedFilePath);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('csv.upload')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
