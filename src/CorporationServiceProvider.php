<?php

namespace Uiaciel\Corporation;

use Livewire\Livewire;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Uiaciel\Corporation\Models\Stock;
use Uiaciel\Corporation\Models\Announcement;
use Uiaciel\Corporation\Models\Report;

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

        $stocks = collect();
        $announcements = collect();
        $reports = collect();

        try {
            $stockTable = (new Stock())->getTable();
            if (Schema::hasTable($stockTable)) {
                $stocks = Stock::all();
            }
            $announcementTable = (new Announcement())->getTable();
            if (Schema::hasTable($announcementTable)) {
                $announcements = Announcement::all();
            }
            $reportTable = (new Report())->getTable();
            if (Schema::hasTable($reportTable)) {
                $reports = Report::all();
            }
        } catch (QueryException $e) {
            // Hindari error saat migrasi / DB belum siap
            // logger()->warning('CorporationServiceProvider DB error: '.$e->getMessage());
        } catch (\Exception $e) {
            // logger()->warning('CorporationServiceProvider Exception: '.$e->getMessage());
        }

        // Share ke semua view frontend
        View::share([
            'stocks' => $stocks,
            'announcements' => $announcements,
            'reports' => $reports,
        ]);

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
                [
                    'label' => 'Stocks',
                    'icon' => 'bi bi-graph-up-arrow',
                    'route' => '/admin/corporation/stocks',
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
