<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Request;
// use Debugbar;


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

Route::get('/', [HomeController::class,"root"]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

Route::get("/video",[HomeController::class,"video"]);

Route::get('/video/{filename}', function ($filename) {
    // Pasta dos videos.
    $videosDir = base_path('public/storage/SFW');
    if (!file_exists($filePath = $videosDir."/".$filename)){
        $videosDir = base_path('public/storage/NSFW');
    }
    if (file_exists($filePath = $videosDir."/".$filename)) {
        $stream = new \App\Http\VideoStream($filePath);

        return response()->stream(function() use ($stream) {
            $stream->start();
        });
    }

    return response("File doesn't exists ".$videosDir."/".$filename, 404);
});