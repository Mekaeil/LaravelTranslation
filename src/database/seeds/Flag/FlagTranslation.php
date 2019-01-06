<?php

namespace database\seeds\laravelTranslation;

use Mekaeil\LaravelTranslation\src\database\seeds\Flag\MasterFlagTranslation;

class FlagTranslation extends MasterFlagTranslation
{

    protected $languages = [

        [
            'name'          => 'en',
            'display_name'  => 'English',
            'status'        => true,
            'default'       => false,
        ],
        [
            'name'          => 'fa',
            'display_name'  => 'فارسی',
            'status'        => true,
            'default'       => true,
        ],


    ];

}
