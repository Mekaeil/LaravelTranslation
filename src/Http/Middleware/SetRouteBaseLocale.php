<?php

namespace Mekaeil\LaravelTranslation\Http\Middleware;

use Closure;
use Mekaeil\LaravelTranslation\Models\FlagTranslation;
use Mekaeil\LaravelTranslation\Repository\Facade\Translation;

class SetRouteBaseLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $currentLocale  =  app()->getLocale();

            $locale         = \Cookie::get('language') ?? $currentLocale;
            $getURL         = Translation::getUrlBaseLocale($locale);
            $currentURL     = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//            dd(substr(parse_url($getURL, PHP_URL_PATH),1));
            $pathLocaleURL = substr(parse_url($getURL, PHP_URL_PATH),1);

            ////// REMOVE '/' AT THE END OF THE URL'S PATH
            $pathLocaleURL = substr($pathLocaleURL,strlen($pathLocaleURL)-1 ) == '/' ? substr($pathLocaleURL,0,strlen($pathLocaleURL)-1 ) : $pathLocaleURL;


            
//            if ($this->ifOnHomePage($locale,$currentURL) && $this->checkRoute($pathLocaleURL) &&  $currentURL != $getURL )
//            {
//                return redirect()->to( url('/') . '/' . $locale );
//            }
//            else
            if( $this->checkRoute($pathLocaleURL) &&  $currentURL != $getURL )
            {
                return redirect()->to(Translation::uri($getURL,$locale));
            }

        }

        return $next($request);
    }


    function checkRoute($route)
    {
        $routes = \Route::getRoutes()->getRoutes();
        foreach($routes as $r)
        {
            if($r->uri() == $route){
                return true;
            }
        }

        return false;
    }

    public function ifOnHomePage($locale,$url=null)
    {
        $home         = url('/');
        $currentURL   = $url ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $currentURL     = \Session::get('_previous')['url'];

            $target     = parse_url($currentURL, PHP_URL_SCHEME) . "://";
            $target    .= parse_url($currentURL, PHP_URL_HOST);
            $target    .= parse_url($currentURL, PHP_URL_PORT) ? ':' : '';
            $target    .= parse_url($currentURL, PHP_URL_PORT);
            $home       = $target;
        }

        return ( $currentURL == $home . '/' . $locale || $currentURL == $home . '/' . $locale . '/' || $currentURL == $home || $currentURL == $home . '/');
    }



}