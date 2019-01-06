<?php

namespace Mekaeil\LaravelTranslation\src\database\seeds;

use database\seeds\laravelTranslation\BaseTranslation;
use database\seeds\laravelTranslation\FlagTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class LaravelTranslationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        /*
        |--------------------------------------------------------------------------
        | FLAG TRANSLATION FOR INSERTING LANGUAGES IN DB
        |--------------------------------------------------------------------------
        |
        |
        */

            $this->call(FlagTranslation::class);


        /*
        |--------------------------------------------------------------------------
        | BASE TRANSLATION FOR INSERTING GENERAL WORDS
        |--------------------------------------------------------------------------
        |
        |
        */

            $this->call(BaseTranslation::class);
    }
}
