<?php

namespace Uiaciel\Corporation;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Uiaciel\Corporation\View\Components\ImportExportOffcanvas;
use Uiaciel\Corporation\View\Components\SessionStatus;

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

        Livewire::componentNamespace('Uiaciel\\Corporation\\Livewire', 'corporation');

        // Register components
        $this->loadViewComponentsAs('corporation', [
            ImportExportOffcanvas::class,
            SessionStatus::class,
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
