<?php

//namespace database\seeds\laravelTranslation;

use Mekaeil\LaravelTranslation\database\seeds\Base\MasterBaseTranslation;


class BaseTranslation extends MasterBaseTranslation
{

    protected $translations = [

    /*
    |--------------------------------------------------------------------------
    | ENGLISH
    |--------------------------------------------------------------------------
    |
    |
    */

        [
            'key'       => 'Welcome',
            'value'     => 'Welcome',
            'locale'    => 'en',
        ],
        [
            'key'       => 'login',
            'value'     => 'login',
            'locale'    => 'en',
        ],
        [
            'key'       => 'logout',
            'value'     => 'logout',
            'locale'    => 'en',
        ],
        [
            'key'       => 'profile',
            'value'     => 'profile',
            'locale'    => 'en',
        ],

    /*
    |--------------------------------------------------------------------------
    | PERSIAN
    |--------------------------------------------------------------------------
    |
    |
    */


        [
            'key'       => 'Welcome',
            'value'     => 'خوش آمدید',
            'locale'    => 'fa',
        ],
        [
            'key'       => 'login',
            'value'     => 'ورود',
            'locale'    => 'fa',
        ],
        [
            'key'       => 'logout',
            'value'     => 'خروج',
            'locale'    => 'fa',
        ],
        [
            'key'       => 'profile',
            'value'     => 'پروفایل',
            'locale'    => 'fa',
        ],



    ];

}
