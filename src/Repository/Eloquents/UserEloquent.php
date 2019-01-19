<?php

namespace Mekaeil\LaravelTranslation\Repository\Eloquents;

use Mekaeil\LaravelTranslation\Models\BaseTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\CoreEloquents;
use Mekaeil\LaravelTranslation\Repository\Contracts\UserRepositoryInterface;

class UserEloquent extends CoreEloquents implements UserRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = config('laravel-translation.user_model');
    }

}