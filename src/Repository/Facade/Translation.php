<?php

namespace Mekaeil\LaravelTranslation\Repository\Facade;

use Illuminate\Support\Facades\Facade;

class Translation extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'translation';
    }
}