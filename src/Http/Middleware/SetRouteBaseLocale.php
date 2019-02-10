<?php

namespace Mekaeil\LaravelTranslation\Http\Middleware;

use Closure;
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

            $pathLocaleURL = substr(parse_url($getURL, PHP_URL_PATH),1);

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


}