<?php

namespace App\Providers;

use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
 
    public function boot(): void
    {
        // Register your custom middleware
        $router = $this->app->make('router');
        $router->aliasMiddleware('apiKey', ApiKeyMiddleware::class);

        // Define your API routes and apply the middleware
        Route::middleware(['apiKey'])->group(function () {
            Route::get('/api/videos', [\App\Http\Controllers\Api\ApiController::class, 'getVideos']);
            Route::get('/api/documents', [\App\Http\Controllers\Api\ApiController::class, 'getDocuments']);
            Route::get('/api/posts', [\App\Http\Controllers\Api\ApiController::class, 'getPosts']);
        });
    }
}