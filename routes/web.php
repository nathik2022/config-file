<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'home'])->name('home.index');

Route::get('/files/merge',[FilesController::class,'merge'])->name('files.merge');

// Route::post('/files/test',[FilesController::class,'storeAs'])->name('files.storeAs');

Route::post('/files/mergeFiles',[FilesController::class,'mergeFiles'])->name('files.mergeFiles');

Route::post('/files/search/{file}',[FilesController::class,'search'])->name('files.search');

Route::resource('files',FilesController::class);





