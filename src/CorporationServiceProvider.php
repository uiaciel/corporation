<?php

namespace Uiaciel\Corporation;

use Livewire\Livewire;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class CorporationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'corporation');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        foreach (File::allFiles(__DIR__ . '/Livewire') as $file) {
            $class = 'Uiaciel\\Corporation\\Livewire\\' . $file->getFilenameWithoutExtension();
            $alias = 'corporation.' . \Illuminate\Support\Str::kebab($file->getFilenameWithoutExtension());
            Livewire::component($alias, $class);
        }

        // Daftarkan Blade components
        $this->loadViewComponentsAs('corporation', [
            \Uiaciel\Corporation\View\Components\ImportExportOffcanvas::class,
            \Uiaciel\Corporation\View\Components\SessionStatus::class,
        ]);

        if (function_exists('register_admin_menupackage')) {
            register_admin_menupackage('Corporation', [
                [
                    'label' => 'Announcements',
                    'icon' => 'bi bi-megaphone-fill',
                    'route' => '/admin/corporation/announcements',
                ],
                [
                    'label' => 'Reports',
                    'icon' => 'bi bi-filetype-pdf',
                    'route' => '/admin/corporation/reports',
                ],
            ]);
        }

        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/corporation.php' => config_path('corporation.php'),
        ], 'corporation-config');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/corporation'),
        ], 'corporation-views');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/corporation'),
        ], 'corporation-assets');
    }
}
