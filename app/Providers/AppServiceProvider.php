<?php

namespace App\Providers;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8'); 
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Superadmin') ? true : null;
        });

        $this->adminlteConfig();
    }

    public function adminlteConfig()
    {
        if ($this->app->runningInConsole()) {
            return;
        }
    
        try {
            DB::connection()->getPdo();

            if (!Schema::hasTable('options')) {
                return;
            }

            $settings = app(Option::class)
                ->whereIn('key', [
                    'title',
                    'description',
                    'sidebar_logo_filepath'
                ])
                ->get();

            $title = $settings->first(fn($i) => $i->key == 'title')?->value;
            if($title) {
                config()->set('adminlte.title', $title);
                config()->set('adminlte.logo', $title);
            }
            $description = $settings->first(fn($i) => $i->key == 'description')?->value;
            if($description) {
                config()->set('adminlte.description', $description);
            }
            $sidebarLogoPath = $settings->first(fn($i) => $i->key == 'sidebar_logo_filepath')?->value;
            $sidebarLogoUrl = $sidebarLogoPath ? Storage::url($sidebarLogoPath) : null;
            if ($sidebarLogoUrl) {
                config()->set('adminlte.logo_img', $sidebarLogoUrl);
            }

        } catch (\Throwable $e) {
            // jangan matiin app cuma gara2 DB
            report($e);
        }
    }
}
