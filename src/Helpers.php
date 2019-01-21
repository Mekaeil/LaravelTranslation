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

if (!function_exists('_trans'))
{

    /**
     * @param $word
     * @param null $lang
     * @param string $where
     * @return mixed
     */
    function _trans($word, $lang=null, $where='file')
    {
        return Translation::translation($word,$lang,$where);
    }

}

if (!function_exists('getUserLocale'))
{

    /**
     * @param $user [ USER MODEL ]
     * @param $param [ 'lang','dir', null ]
     * @return mixed
     */

    function getUserLocale($user=null,$param=null)
    {
        return Translation::getUserLocale($user,$param);
    }

}


if (!function_exists('setAssets'))
{

    /**
     * @param string $where
     * @param null $type
     * @param null $lang
     * @return mixed
     */

    function setAssets($where='front-end', $update=false, $type=null, $lang=null)
    {
        return Translation::setAssets($where, $update, $type, $lang);
    }

}

