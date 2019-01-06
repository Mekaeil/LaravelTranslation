<?php

/**
 *
 *  THIS HELPER JUST USED FOR PUBLISH IN LARAVEL PROJECT
 *
 */

use Mekaeil\LaravelTranslation\TransHelper;
class Trans{
    use TransHelper;

    public function translator($word,$lang,$where){
        return $this->translation($word,$lang,$where);
    }
}

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
        $accessTrans = new Trans();
        return $accessTrans->translator($word,$lang,$where);
    }

}


