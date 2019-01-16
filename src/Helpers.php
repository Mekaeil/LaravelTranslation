<?php

/**
 *
 *  THIS HELPER JUST USED FOR PUBLISH IN LARAVEL PROJECT
 *
 */

use Mekaeil\LaravelTranslation\Repository\Facade\Translation;

if (!function_exists('translation'))
{

    /**
     * @param $word
     * @param null $lang
     * @param string $where
     * @return mixed
     */
    function translation($word, $lang=null, $where='file')
    {
        return Translation::translation($word,$lang,$where);
    }

}


