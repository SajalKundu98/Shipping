<?php

use App\Http\Controllers\UploadController;
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

Route::get('clear-cache', function(){
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('storage:link');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('preview', [UploadController::class, 'previewData']);
Route::post('preview-update', [UploadController::class, 'previewDataUpdate']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('image-upload', [UploadController::class, 'uploadFile']);

Route::get('all-orders', [UploadController::class, 'allOrders']);
Route::get('customer-info', [UploadController::class, 'customerInfo']);
Route::get('orders/{id}', [UploadController::class, 'show']);
Route::delete('orders/{id}', [UploadController::class, 'destroy']);
