<?php


use Calima\LandingBuilder\Controllers\GrapesJs\CssController;
use Calima\LandingBuilder\Controllers\GrapesJs\GetBuilderFiles;
use Calima\LandingBuilder\Controllers\GrapesJs\JsController;
use Calima\LandingBuilder\Controllers\GrapesJs\StoreBuilderFiles;
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


Route::get('/js/grapesjseditor.js', JsController::class);
Route::get('/css/grapesjseditor.css', CssController::class);
Route::get('/builder/files', GetBuilderFiles::class)->name('builder.files');
Route::post('/builder/files', StoreBuilderFiles::class);

