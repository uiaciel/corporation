<?php

namespace Uiaciel\Corporation;

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

        // Livewire::component('corporation.announcement-create', AnnouncementCreate::class);

        // Daftarkan Blade components
        $this->loadViewComponentsAs('corporation', [
            \Uiaciel\Corporation\View\Components\ImportExportOffcanvas::class,
            \Uiaciel\Corporation\View\Components\SessionStatus::class,
        ]);

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
