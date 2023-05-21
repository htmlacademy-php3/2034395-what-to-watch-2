<?php

namespace App\Providers;

use App\Jobs\AddFilm;
use App\Services\FilmsApiService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bindMethod([AddFilm::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(FilmsApiService::class));
        });
    }
}
