<?php

namespace Mekaeil\LaravelTranslation\Repository\Eloquents;

use Mekaeil\LaravelTranslation\Models\FlagTranslation;

use Mekaeil\LaravelTranslation\Repository\Contracts\CoreEloquents;
use Mekaeil\LaravelTranslation\Repository\Contracts\FlagRepositoryInterface;

class FlagEloquent extends CoreEloquents implements FlagRepositoryInterface
{

    protected $model = FlagTranslation::class;

    public function getDirection()
    {
        return [
            'rtl'   => 'Right To Left',
            'ltr'   => 'Left To Right',
        ];
    }

}