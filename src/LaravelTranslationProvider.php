<?php

namespace Mekaeil\LaravelTranslation;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Mekaeil\LaravelTranslation\Exceptions\Handler;
use Mekaeil\LaravelTranslation\Repository\Contracts\AssetRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\ModuleRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\UserRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Eloquents\AssetEloquent;
use Mekaeil\LaravelTranslation\Repository\Eloquents\BaseEloquent;
use Mekaeil\LaravelTranslation\Repository\Eloquents\FlagEloquent;
use Mekaeil\LaravelTranslation\Repository\Eloquents\ModuleEloquent;
use Mekaeil\LaravelTranslation\Repository\Eloquents\UserEloquent;
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
        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );

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

        ///  PUBLISH LANGUAGE FILES
        ////////////////////////////////////////////////////////////////////////////////////////////////////

            $this->publishes([
                __DIR__ . '/lang/en/laraTrans.php' => resource_path('/lang/en/laraTrans.php'),
            ]);

            $this->publishes([
                __DIR__ . '/lang/fa/laraTrans.php' => resource_path('/lang/fa/laraTrans.php'),
            ]);

            $this->publishes([
                __DIR__ . '/lang/ku/laraTrans.php' => resource_path('/lang/ku/laraTrans.php'),
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

        $this->app->bind(AssetRepositoryInterface::class, AssetEloquent::class);

        $this->app->bind(UserRepositoryInterface::class, UserEloquent::class);

        $this->app->bind('translation', function ($app){
            return new TransHelper();
        });

        if (file_exists( app_path("Http/LaraTransHelper.php") )){
            require_once app_path("Http/LaraTransHelper.php");
        }

    }
}
