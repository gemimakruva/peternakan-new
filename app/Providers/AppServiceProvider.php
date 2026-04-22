<?php

namespace App\Providers;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;
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

            if (Module::isEnabled('GudangTelur')) {
                config()->push('adminlte.menu.5.submenu', [
                    'text'  => 'Kemasan',
                    'route' => 'gudang-telur.master-data.kemasan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['gudang-telur/master-data/kemasan*'],
                    'can'   => 'master-data.master-data.menu-kemasan',
                ]);
                foreach (config('gudang-telur.menu') as $menu) {
                    config()->push('adminlte.menu', $menu);
                }
            }

            if (Module::isEnabled('GudangPakan')) {
                config()->push('adminlte.menu.5.submenu', [
                    'text'  => 'Bahan Pakan',
                    'route' => 'gudang-pakan.master-data.bahan-pakan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['gudang-pakan/master-data/bahan-pakan*'],
                    'can'   => 'master-data.master-data.menu-bahan-pakan',
                ]);
                foreach (config('gudang-pakan.menu') as $menu) {
                    config()->push('adminlte.menu', $menu);
                }
            }

            // dd(config('adminlte.menu.5.submenu'));
        } catch (\Throwable $e) {
            // jangan matiin app cuma gara2 DB
            report($e);
        }
    }
}
