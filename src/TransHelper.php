<?php

namespace Mekaeil\LaravelTranslation\TransHelper;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Mekaeil\LaravelTranslation\Repository\Contracts\AssetRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\UserRepositoryInterface;

class TransHelper
{

    private function appLangRegister()
    {
        return app(FlagRepositoryInterface::class);
    }


    private function appBaseWordRegister()
    {
        return app(BaseRepositoryInterface::class);
    }


    private function appAssetRegister()
    {
        return app(AssetRepositoryInterface::class);
    }


    private function appUserRegister()
    {
        return app(UserRepositoryInterface::class);
    }

    public $locale;

    /**
     * @param int|null $days
     * @return \Illuminate\Config\Repository|int|mixed
     */
    private function calcCookieTime(int $days=null)
    {
        if (!$days)
        {
            $days = config('laravel-translation.cookie_expire_time') ?? 90;
        }

        return $days * ( 24 * 60 );
    }


    /**
     * @param $cookieName
     * @param $cookieValue
     * @param $cookieTime
     * @param null $path
     */
    private function setCookie($cookieName , $cookieValue , $cookieTime , $path=null)
    {
        Cookie::queue(
            $cookieName , $cookieValue , $cookieTime , $path
        );
        return true;
    }


    /**
     * @param $cookieName
     * @param string $path
     */
    private function deleteCookie($cookieName , $path='/')
    {

        if (is_array($cookieName))
        {
            foreach ($cookieName as $key => $value)
            {
                if(Request::hasCookie($value)){
                    $this->deleteCookie($value);
                }
            }
            return true;
        }

        Cookie::queue(
            $cookieName , '' , -1 , $path
        );
        return true;

    }


    /**
     * @param $key
     * @return bool
     */
    private function deleteSession($key)
    {

        if (is_array($key))
        {
            foreach ($key as $item)
            {
                $this->deleteSession($item);
            }

            return true;
        }

        if ($key=='all')
        {
            Session::flush();
            return true;
        }

        Session::forget($key);
        return true;

    }


    /**
     * @param $lang [ fa , en , ... ] locale
     * @param $dir [ rtl, ltr ]
     * @param string $where [ front-end , back-end ]
     * @return bool
     */
    private function setAllCookieData($lang, $dir, $where="front-end")
    {
        $this->getAssets($where, null, $lang);
        $this->setCookie( 'language' ,$lang ,$this->calcCookieTime() );
        $this->setCookie( 'direction' ,$dir ,$this->calcCookieTime() );

        return true;
    }


    /**
     * @param $type
     * @param $source
     * @param string $path_type
     * @return string
     */
    private function assetTagLinkGeneration($type, $source, $path_type='asset')
    {

        $length     = strpos(trim($type),'_');
        $typeTag    = substr(trim($type),0,$length);
        $hrefLink   = substr(trim($type), 0 , $length) == 'link' ? $path_type($source) : '';
        $tag        = '<' . $typeTag;

        switch ($type)
        {
            case 'link_style':
                $tag   .= '  href="' . $hrefLink  . '" rel="stylesheet">';
                break;

            case 'link_script':
                $tag   .= '  src="' . $hrefLink . '">';
                break;

            default:
                $tag   .= '>';
                $tag   .= $source;
                break;
        }

        return $tag   .= "</$typeTag>";

    }

    /**
     * @return mixed
     */
    public function allLangs($active=true,$pluck=false)
    {

        $condition = array();
        if ($active)
        {
            $condition = array_merge($condition,[
                'status' => true
            ]);
        }

        if ($pluck)
        {
            return $this->appLangRegister()->pluckData('display_name','name',true,$condition);
        }

        return $this->appLangRegister()->all([],[],null,$condition);

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


    /**
     * @param string $where [ front-end , back-end ]
     * @param null $type    [ link_style, style_custom, link_script, script_custom]
     * @param null $lang    [ fa , en , ... ]
     * @return bool|null    []
     */
    public function getAssets($where='front-end', $type=null, $lang=null)
    {

        $condition  = array();
        $lang_id    = null;

        $styles     = array();
        $scripts    = array();

        if ($where && !in_array($where, array_keys($this->appAssetRegister()->getPositionStyle())))
        {
            return null;
        }

        if ($type && !in_array($type, array_keys($this->appAssetRegister()->getAssetTypes())))
        {
            return null;
        }


        /// GET LANGUAGE FOR FIND LANGUAGE'S ASSETS
        ////////////////////////////////////////////////////////////////////
        if ($lang)
        {
            $lang_id = $this->appLangRegister()->getRecord([
                'name'  => $lang,
            ]);
        }
        $lang_id = $lang_id ? $lang_id->id : $this->getUserLocale()->id;

        $condition = array_merge($condition,[
            'lang_id'    => $lang_id,
        ]);
        ////////////////////////////////////////////////////////////////////

        $assets = $this->appAssetRegister()->all([], [], null, $condition);

        //// WHEN TYPE IS NULL, RETURN ALL TYPE OF ASSETS
        ////////////////////////////////////////////////////////////////////
        if ($type)
        {
            $condition = array_merge($condition,[
                'type'    => $type,
            ]);
        }
        ////////////////////////////////////////////////////////////////////

        $condition = array_merge($condition,[
            'where'    => $where,
        ]);

        $assets = $this->appAssetRegister()->all([], [], null, $condition);

        /// GENERATE LINK
        ////////////////////////////////////////////////////////////////////

        if ($assets && !Request::hasCookie('assets'))
        {
            foreach ($assets as $asset)
            {
                if ($asset->type)
                {
                    $assetTags[$asset->type] = $this->assetTagLinkGeneration($asset->type,$asset->source,$asset->path_type);
                }
                else{
                    continue;
                }
            }

            if (isset($assetTags))
            {
                $this->setCookie('assets', json_encode($assetTags), $this->calcCookieTime());
            }
//            dd(Request::hasCookie('assets'));

        }

        return true;
    }


    /**
     * @param string $where
     * @param bool $update
     * @param null $type [ link_style, style_custom, link_script, script_custom]
     * @param null $lang
     * @return bool
     */
    public function setAssets($where='front-end', $update=false, $type=null, $lang=null)
    {

        if ($update)
        {
            $this->clearCache('assets');
        }

        if (!Request::hasCookie('assets'))
        {
            return $this->getAssets($where, $type, $lang);
        }

        return true;

    }


    /**
     * @param null $user
     * @param null $param
     * @return mixed
     */
    public function getUserLocale($user=null, $param=null)
    {

        $user = $user ?? \Auth::user();

        if ($user && !$user->lang_id)
        {
            $getLanguage = $this->defaultLang();

            $this->appUserRegister()->update($user->id,
            [
                'lang_id'   => $getLanguage->id,
            ]);

        }
        elseif($user)
        {

            $getLanguage = $this->appLangRegister()->find($user->lang_id);

        }
        else
        {
            $getLanguage = $this->defaultLang();
        }

        /// IF PARAM EXIST
        ////////////////////////////////////////////////////////
        if ($param){

            switch ($param){
                case 'lang':
                    return $getLanguage->name;
                    break;
                case 'dir':
                    return $getLanguage->direction;
                    break;
            }

        }


        return $getLanguage;

    }


    public function getTransLocale(string $langWith=null)
    {
        $langWith = $langWith ?? config('laravel-translation.save_language_with');

        if ($langWith == 'cookie')
        {
            return Cookie::get('language');
        }

        return Session::get('language');
    }

    /**
     * @param int $userID
     * @param int|null $langID
     * @param string|null $langWith
     * @return bool
     */
    public function setUserLocale(int $userID=null, int $langID=null, string $langWith=null)
    {
        $langWith = $langWith ?? config('laravel-translation.save_language_with');
        $user     = isset($userID) ? $this->appUserRegister()->find($userID) : \Auth::user() ;

        if (!$user)
        {
            $language = $langID ? $this->appLangRegister()->find($langID) : $this->defaultLang();
            return $this->setAllCookieData($language->name,$language->direction);
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

            /// SKIP THE NON-OBJECT ERROR ;) :D
            ////////////////////////////////////////////////////////
            if (!$user->lang_id){
                $this->appUserRegister()->update($user->id,[
                    'lang_id'   => $this->defaultLang()->id
                ]);
            }

            $language = $this->appLangRegister()->find($user->lang_id);
        }

        /////////////////////////////////////////////////////////////////

        if ($langWith == 'cookie')
        {
            $this->setAllCookieData($language->name,$language->direction);
            return App::setLocale($language->name);
        }

        session([
            'language' => $language->name,
            'direction'=> $language->direction
        ]);

        /// use cookie for assets
        ///////////////////////////
        $this->getAssets('front-end',null, $language->name);

        return App::setLocale($language->name);
    }


    /**
     * @param $parameters
     * @return bool
     */
    public function clearCache($parameters, $where=null)
    {

        $clearCacheIn = $where ?? config('laravel-translation.save_language_with');

        if ($clearCacheIn == 'cookie')
        {
            return $this->deleteCookie($parameters);
        }

        return $this->deleteSession($parameters);

    }

    public function uri($url=null)
    {

        if ($url)
        {
            if (! \Request::is($url))
            {
                $locale       =  app()->getLocale();
                $urlWithoutLocale   =  str_replace('/'.$locale,'',$url);
                return $urlWithoutLocale;
            }

            return 'here';
        }

        $urlBaseLocale = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". app()->getLocale() ."$_SERVER[REQUEST_URI]";


        if (! \Request::is($urlBaseLocale))
        {

            $locale             = app()->getLocale();
            $urlBaseLocale      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $urlWithoutLocale   =  str_replace('/'.$locale,'',$urlBaseLocale);

//            return redirect()->to($urlWithoutLocale);
            return $urlWithoutLocale;
        }

        return  $urlBaseLocale;
//        return redirect()->to($urlBaseLocale);
    }


    public function getUrlBaseLocale($locale)
    {
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $url = \Session::get('_previous')['url'];

            $target     = parse_url($url, PHP_URL_SCHEME) . "://";
            $target    .= parse_url($url, PHP_URL_HOST) . ':'. parse_url($url, PHP_URL_PORT) . '/' . $locale ;
            $target    .= parse_url($url, PHP_URL_PATH);
            $target    .= parse_url($url, PHP_URL_QUERY) ? '/' . parse_url($url, PHP_URL_QUERY) : '';
            $target    .= parse_url($url, PHP_URL_FRAGMENT) ? '/' . parse_url($url, PHP_URL_FRAGMENT) : '';
            return $target;
        }


        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". app()->getLocale() ."$_SERVER[REQUEST_URI]";
    }

//
//    public function uri()
//    {
//        $urlBaseLocale = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". $this->locale ."$_SERVER[REQUEST_URI]";
//
//        $handle = curl_init($urlBaseLocale);
//        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
//
//        /* Get the HTML or whatever is linked in $url. */
//        $response = curl_exec($handle);
//
//        /* Check for 404 (file not found). */
//        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
//        if($httpCode == 404) {
//            dd('here');
//
//            /* Handle 404 here. */
//        }
//        curl_close($handle);
//
//        return redirect()->to($urlBaseLocale, 301);
//    }


}

