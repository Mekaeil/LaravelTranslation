<?php

/*
|--------------------------------------------------------------------------
| Web Routes Laravel-translation
|--------------------------------------------------------------------------
|
|
*/

    $middlewares =  config('laravel-translation.middleware');

    Route::group([
        'namespace'     => 'Mekaeil\LaravelTranslation\Http\Controller',
        'middleware'    => $middlewares,
        'as'            => 'admin.trans.',
        'prefix'        => 'admin/translation',
    ],
    function (){

        // admin.trans.lang.index
        Route::get('/languages', 'FlagTranslateController@index')
            ->name('lang.index');

        // admin.trans.lang.create
        Route::get('/create', 'FlagTranslateController@create')
            ->name('lang.create');

        // admin.trans.lang.store
        Route::post('/store', 'FlagTranslateController@store')
            ->name('lang.store');

        // admin.trans.lang.edit
        Route::get('/edit/{lang}', 'FlagTranslateController@edit')
            ->name('lang.edit');

        // admin.trans.lang.update
        Route::post('/update/{lang}', 'FlagTranslateController@update')
            ->name('lang.update');

        // admin.trans.lang.set.as.default
        Route::post('/set-default-language/{lang}', 'FlagTranslateController@setDefault')
            ->name('lang.set.as.default');

        // admin.trans.lang.confirm.delete
        Route::delete('/delete/{lang}', 'FlagTranslateController@delete')
            ->name('lang.confirm.delete');

        // admin.trans.lang.switch.language
        Route::post('/switch-language','FlagTranslateController@switchLanguage')
            ->name('lang.switch.language');

        /// BASE TRANSLATION SECTION
        ///////////////////////////////////////////////////////////////////////
        Route::group([
            'prefix'    => 'base',
            'as'        => 'base.',
        ],
        function (){

            // admin.trans.base.index
            Route::get('/list', 'BaseTranslateController@index')
                ->name('index');

            // admin.trans.base.create
            Route::get('/create', 'BaseTranslateController@create')
                ->name('create');

            // admin.trans.base.store
            Route::post('/store', 'BaseTranslateController@store')
                ->name('store');

            // admin.trans.base.edit
            Route::get('/edit/{trans}', 'BaseTranslateController@edit')
                ->name('edit');

            // admin.trans.base.update
            Route::post('/update/{trans}', 'BaseTranslateController@update')
                ->name('update');

            // admin.trans.base.delete.confirm
            Route::delete('/delete-confirm/{trans}', 'BaseTranslateController@delete')
                ->name('delete.confirm');

        });


        /// MODULE TRANSLATION SECTION
        ///////////////////////////////////////////////////////////////////////
        Route::group([
            'prefix'    => 'modules',
            'as'        => 'module.',
        ],
        function (){

            // admin.trans.module.index
            Route::get('/list', 'ModuleTranslateController@index')
                ->name('index');

            // admin.trans.module.create
            Route::get('/create', 'ModuleTranslateController@create')
                ->name('create');

            // admin.trans.module.store
            Route::post('/store', 'ModuleTranslateController@store')
                ->name('store');

            // admin.trans.module.edit
            Route::get('/edit/{translate}', 'ModuleTranslateController@edit')
                ->name('edit');

            // admin.trans.module.update
            Route::post('/update/{translate}', 'ModuleTranslateController@update')
                ->name('update');

        });

        /// ASSET TRANSLATION
        /////////////////////////////////////////////////////////////////////
        Route::group([
            'prefix'    => 'assets',
            'as'        => 'assets.',
        ],
        function (){

                // admin.trans.assets.index
                Route::get('/list', 'AssetsTranslateController@index')
                    ->name('index');

                // admin.trans.assets.create
                Route::get('/create', 'AssetsTranslateController@create')
                    ->name('create');

                // admin.trans.assets.store
                Route::post('/store', 'AssetsTranslateController@store')
                    ->name('store');

                // admin.trans.assets.edit
                Route::get('/edit/{asset}', 'AssetsTranslateController@edit')
                    ->name('edit');

                // admin.trans.assets.update
                Route::post('/update/{asset}', 'AssetsTranslateController@update')
                    ->name('update');

                // admin.trans.assets.delete.confirm
                Route::delete('/delete-confirm/{asset}', 'AssetsTranslateController@delete')
                    ->name('delete.confirm');

            });



    });


    Route::group([
        'namespace'     => 'Mekaeil\LaravelTranslation\Http\Controller',
        'middleware'    => 'web',
        'as'            => 'trans.',
        'prefix'        => 'translation',
    ],
    function (){

        // trans.lang.switch.language
        Route::post('/switch-language','FlagTranslateController@switchLanguage')
            ->name('lang.switch.language');

    });

//Route::get('{uri?}', [
//    'uses'  => 'Mekaeil\LaravelTranslation\Http\Controller\CoreTranslateController@uri',
//])->where('uri', '.*');