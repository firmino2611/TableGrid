<?php

namespace Firmino\TableGrid\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Firmino\TableGrid\Table;

class TableGridServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(){
        $this->loadViewsFrom(__DIR__ . '/../Resources', 'Table');

        $this->publishes([
            __DIR__ . '/../Config/table.php' => config_path('table.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/table.php',
            'table'
        );

        $this->app->singleton('Table.table', function(){
            return new Table();
        });
    }
}
