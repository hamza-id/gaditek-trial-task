<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CsvFileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('csv/upload',  [CsvFileController::class, 'showUploadForm'])->name('csv.upload');
Route::post('csv/sorted', [CsvFileController::class, 'uploadCsv'])->name('csv.sorted.store');
