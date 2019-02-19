<?php

namespace Mekaeil\LaravelTranslation\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Crypt;


class Handler extends ExceptionHandler
{

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        /// CHECK IF ROUTE BASE LOCALE THROW TO 404 REMOVE LOCALE IN URL
        ///////////////////////////////////////////////////////////////////////////////
        if ($exception instanceof NotFoundHttpException && $_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $locale = app()->getLocale();
            if (Cookie::has('language'))
            {
                $locale = Crypt::decryptString(Cookie::get('language'));
            }

            $currentURL     = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//            /// CHECK WHEN WE ARE IN HOME PAGE
//            //////////////////////////////////////////////////////////////////////////////
//            $target     = parse_url($currentURL, PHP_URL_SCHEME) . "://";
//            $target    .= parse_url($currentURL, PHP_URL_HOST);
//            $target    .= parse_url($currentURL, PHP_URL_PORT) ? ':' : '';
//            $target    .= parse_url($currentURL, PHP_URL_PORT);
//            $start      = strlen($target) + strlen($locale) + 1;

            $ifLocaleExist  = strpos($currentURL,'/'.$locale.'/');

            if ($ifLocaleExist)
            {
                $newUrl   =  str_replace('/'.$locale.'/','/',$currentURL);
                return redirect()->to($newUrl);
            }
            elseif(strpos($currentURL,'/'.$locale))
            {
                dd('ss');
                $newUrl   =  str_replace('/'.$locale,'/',$currentURL);
                return redirect()->to($newUrl);
            }

        }
        ///////////////////////////////////////////////////////////////////////////////

        return parent::render($request, $exception);
    }
}
