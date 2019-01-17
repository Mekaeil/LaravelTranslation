<?php

namespace Mekaeil\LaravelTranslation\TransHelper;

use Illuminate\Support\Facades\App;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\UserRepositoryInterface;

class TransHelper
{

    private function appLangRegister(){
        return app(FlagRepositoryInterface::class);
    }

    private function appBaseWordRegister(){
        return app(BaseRepositoryInterface::class);
    }

    private function appUserRegister(){
        return app(UserRepositoryInterface::class);
    }

    /**
     * @return mixed
     */
    public function allLangs()
    {
        return $this->appLangRegister()->all([],[],null,['status' => true]);
    }

    /**
     * @return mixed
     */
    public function defaultLang(int $userID=null)
    {
        if ($userID)
        {
            $getUser = $this->appUserRegister()->find($userID);
            if ($langID = $getUser->lang_id)
            {
                return $getLang = $this->appLangRegister()->find($langID);
            }
        }

        return $this->appLangRegister()->getRecord([
            'default'   => true,
        ],true);

    }

    /**
     * @param null $lang
     * @param null $perPage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function baseWords($key = null ,$lang = null, $perPage = null)
    {

        $first     = false;
        $condition = array();

        if ($lang){

            $language = $this->appLangRegister()->getRecord([
                'name'    => $lang,
            ],true);

            if (is_null($language)){
                return response()->json([
                    'message'   => 'Language does not exist!'
                ]);
            }

            $condition = [
              'lang'    => $language->id,
            ];

        }

        if ($key){

            $condition = array_merge($condition,[
                'key'    => $key,
            ]);

            if (!$lang){

                $language = $this->appLangRegister()->getRecord([
                    'name'    => app()->getLocale(),
                ],true);

                $condition = array_merge($condition,[
                    'lang'    => $language->id,
                ]);

            }

            $first = true;
        }

        return $this->appBaseWordRegister()->getRecord($condition, $first, $perPage);

    }

    /**
     * @param $key
     * @param null $lang
     * @param string $where
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function translation($key, $lang=null, $where='file')
    {
        $fileName   = config('laravel-translation.translation_file_name');
        $key        = $fileName . '.' . $key;

        if (is_null($lang)){
            $lang = app()->getLocale();
        }

        if ($where=='file'){
            return trans($key,[],$lang);
        }

        if ($where=='db'){

            $ifLangExist = $this->appLangRegister()->getRecord([
                'name'    => $lang,
            ],true);

            if (is_null($ifLangExist)){
                return $this->translation($key);
            }

            return $this->appBaseWordRegister()->getRecord([
                    'key'   =>  $key,
                    'lang'  =>  $ifLangExist->id,
                ],true)->value;
        }

    }


    /**
     * @param $key
     * @param null $lang
     * @param string $where
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function _trans($key, $lang=null, $where='file')
    {
       return $this->translation($key,$lang,$where);
    }

    public function getUserLocale()
    {

    }

    public function setUserLocale(int $userID, int $langID=null, string $langWith=null)
    {
        $langWith = $langWith ?? config('laravel-translation.save_language_with');
        $user     = $this->appUserRegister()->find($userID);

        if (!$user && ($user->lang_id || !$langID) )
        {
            return false;
        }

        /// GET LANGUAGE
        /////////////////////////////////////////////////////////////////

        if ($langID)
        {
            $language = $this->appLangRegister()->find($langID);

            if ( $langID != $user->lang_id){
                $this->appUserRegister()->update($user->id,[
                   'lang_id'    => $language->id,
                ]);
            }

        }
        else{
            $language = $this->appLangRegister()->find($user->lang_id);
        }

        /////////////////////////////////////////////////////////////////


        if ($langWith == 'cookie')
        {
            cookie('language', $language->name, $this->calcCookieTime());
            cookie('direction',$language->direction, $this->calcCookieTime());
            App::setLocale($language->name);
            return true;
        }

        session('language', $language->name);
        session('direction', $language->direction);
        App::setLocale($language->name);
        return true;
    }

    public function clearCacheLocale(int $userID)
    {
        $clearCacheIn = config('laravel-translation.save_language_with');
    }

    private function calcCookieTime(int $days=null)
    {
        if (!$days)
        {
            $days = config('laravel-translation.cookie_expire_time') ?? 90;
        }

        return $days * ( 24 * 60 );
    }


}

