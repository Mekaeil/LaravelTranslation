<?php

namespace Mekaeil\LaravelTranslation\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Mekaeil\LaravelTranslation\Repository\Facade\Translation;

class UserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($lang = Translation::getTransLocale() )
        {
            App::setLocale($lang);
        }
        return $next($request);
    }
}
