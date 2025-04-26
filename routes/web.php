<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\PlaylistController;



Route::resource('categories', CategoryController::class);
Route::resource('videos', VideoController::class);
Route::resource('documents', DocumentController::class);
Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
 
Route::resource('api-keys', ApiKeyController::class)->names([
    'index' => 'api-keys.index',
    'create' => 'api-keys.create',
    'store' => 'api-keys.store',
    'show' => 'api-keys.show', // You might not need this
    'edit' => 'api-keys.edit',
    'update' => 'api-keys.update',
    'destroy' => 'api-keys.destroy',
]);


Route::resource('playlists', PlaylistController::class);

Route::get('/api-keys/{apiKey}', [ApiKeyController::class, 'show'])->name('api-keys.show');

use App\Http\Controllers\Api\ApiController; // Hakikisha umeongeza hii namespace
//Route::middleware(['api.key'])->group(function () {
//Route::get('/api/videos', [ApiController::class, 'getVideos']);
//Route::get('/api/documents', [ApiController::class, 'getDocuments']);
//Route::get('/api/posts', [ApiController::class, 'getPosts']);
//});
