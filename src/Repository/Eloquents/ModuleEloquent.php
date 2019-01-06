<?php

namespace Mekaeil\LaravelTranslation\Repository\Eloquents;

use Mekaeil\LaravelTranslation\Models\ModuleTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\CoreEloquents;
use Mekaeil\LaravelTranslation\Repository\Contracts\ModuleRepositoryInterface;

class ModuleEloquent extends CoreEloquents implements ModuleRepositoryInterface
{

    protected $model = ModuleTranslation::class;

}