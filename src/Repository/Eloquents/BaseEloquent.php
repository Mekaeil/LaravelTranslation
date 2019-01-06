<?php

namespace Mekaeil\LaravelTranslation\Repository\Eloquents;

use Mekaeil\LaravelTranslation\Models\BaseTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\BaseRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\CoreEloquents;

class BaseEloquent extends CoreEloquents implements BaseRepositoryInterface
{
    protected $model = BaseTranslation::class;


}