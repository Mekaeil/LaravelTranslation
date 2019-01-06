<?php

namespace Mekaeil\LaravelTranslation\src;

use Illuminate\Support\ServiceProvider;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\ModuleRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Eloquents\BaseEloquent;
use Mekaeil\LaravelTranslation\Repository\Eloquents\FlagEloquent;
use Mekaeil\LaravelTranslation\Repository\Eloquents\ModuleEloquent;
use Mekaeil\LaravelTranslation\TransHelper\TransHelper;

class LaravelTranslationProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (file_exists(app_path('/../routes/route.laratrans.php'))){
            $this->loadRoutesFrom(app_path('/../routes/route.laratrans.php'));
        }else{
            $this->loadRoutesFrom(__DIR__ . '/routes/route.laratrans.php');
        }

        $this->loadViewsFrom(__DIR__ . '/views', 'LaraTrans');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->mergeConfigFrom(__DIR__ . '/config/laravel-translation.php','laravel-translation');


        /// PUBLISH SECTION
        ////////////////////////////////////////////////////////////////////////////////////////////////////

            /// ROUTE
            $this->publishes([
                __DIR__ . '/routes/route.laratrans.php' => app_path('/../routes/route.laratrans.php'),
            ]);

            /// CONFIG
            $this->publishes([
                __DIR__ . '/config/laravel-translation.php' => config_path('laravel-translation.php'),
            ]);

            /// ASSETS
            $this->publishes([
                __DIR__ . '/views' => resource_path('/laravel-translation'),
            ], 'laravel-translation');

            /// SEEDER
            $this->publishes([
                __DIR__ . '/database/seeds/Base/BaseTranslation.php' => database_path('/seeds/laravelTranslation/BaseTranslation.php'),
                __DIR__ . '/database/seeds/Flag/FlagTranslation.php' => database_path('/seeds/laravelTranslation/FlagTranslation.php'),
            ]);

            /// ASSETS
            $this->publishes([
                __DIR__ . '/public/laravel-translation' => public_path('/laravel-translation'),
            ], 'public');

            /// HELPER FILE
            $this->publishes([
                __DIR__ . '/Helpers.php' => app_path('/Http/LaraTransHelper.php'),
            ]);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(FlagRepositoryInterface::class, FlagEloquent::class);

        $this->app->bind(BaseRepositoryInterface::class, BaseEloquent::class);

        $this->app->bind(ModuleRepositoryInterface::class, ModuleEloquent::class);

        require_once "TransHelper.php";

    }
}
