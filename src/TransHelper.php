<?php

namespace Mekaeil\LaravelTranslation\TransHelper;

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
        return $this->appLangRegister()->all();
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

}

