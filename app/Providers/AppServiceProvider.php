<?php

namespace App\Providers;

use App\Services\TranslationService;
use Illuminate\Support\Facades\View;
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
        View::composer('common.nav', function ($view) {
            $view->with('lessons', resolve(TranslationService::class)->getAllLessons());
        });
    }
}
