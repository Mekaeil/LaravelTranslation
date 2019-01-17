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
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'fr',
            'display_name'  => 'français',  // French
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'zh',
            'display_name'  => '漢語', // Chinese
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'de',
            'display_name'  => 'Deutsch', // German
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'hi',
            'display_name'  => 'हिंदी', // Hindi
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'ja',
            'display_name'  => '日本語', // Japanese
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'it',
            'display_name'  => 'Italiano', // Italian
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'fi',
            'display_name'  => 'suomi', // Finnish
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'tr',
            'display_name'  => 'Türkçe', // Turkish
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'es',
            'display_name'  => 'Español', // Spanish
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'pt',
            'display_name'  => 'Português', // Portuguese
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'bn',
            'display_name'  => 'বাংলা', // Bengali
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'ru',
            'display_name'  => 'русский', // Russian
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'pa',
            'display_name'  => 'ਪੰਜਾਬੀ', // Punjabi
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],
        [
            'name'          => 'in',
            'display_name'  => 'Bahasa Indonesia', // Indonesian
            'status'        => false,
            'default'       => false,
            'direction'     => 'ltr',
        ],


        //////////////////////////////////////////////
        [
            'name'          => 'fa',
            'display_name'  => 'فارسی',  // Persian
            'status'        => true,
            'default'       => true,
            'direction'     => 'rtl',
        ],
        [
            'name'          => 'ar',
            'display_name'  => 'العربية', // Arabic
            'status'        => false,
            'default'       => false,
            'direction'     => 'rtl',
        ],
        [
            'name'          => 'ku',
            'display_name'  => 'کوردی',  // Kurdish
            'status'        => false,
            'default'       => false,
            'direction'     => 'rtl',
        ],
        [
            'name'          => 'ps',
            'display_name'  => 'پښتو',  // Pashto
            'status'        => false,
            'default'       => false,
            'direction'     => 'rtl',
        ],
        [
            'name'          => 'ur',
            'display_name'  => 'اردو',  // Urdu
            'status'        => false,
            'default'       => false,
            'direction'     => 'rtl',
        ],


    ];

}
