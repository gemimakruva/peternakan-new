<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Kandang\Models\Pipe;
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
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8'); 
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Superadmin') ? true : null;
        });
    }
}
