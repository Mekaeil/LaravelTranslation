<?php

namespace Mekaeil\LaravelTranslation\Repository\Eloquents;

use Mekaeil\LaravelTranslation\Models\AssetTranslation;
use Mekaeil\LaravelTranslation\Repository\Contracts\AssetRepositoryInterface;
use Mekaeil\LaravelTranslation\Repository\Contracts\CoreEloquents;

class AssetEloquent extends CoreEloquents implements AssetRepositoryInterface
{
    protected $model = AssetTranslation::class;

    public function getAssetTypes()
    {
        return [
            'css_link'      => 'CSS URL',
            'custom_css'    => 'Custom CSS',
            'script_link'   => 'Script URL',
            'custom_script' => 'Custom Script',
        ];
    }

    public function getPathType()
    {
        return [
            'app_path'      => "app_path",
            'resource_path' => "resource_path",
            'asset'         => "asset",
            'url'           => "url"
        ];
    }

    public function getPositionStyle(){
        return [
            'front-end' => 'Front-End',
            'back-end'  => 'Back-End',
        ];
    }

}