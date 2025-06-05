<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Recette;
use App\Policies\RecettePolicy;

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
        //
    }


    protected $policies = [
    Recette::class => RecettePolicy::class,
];
}


