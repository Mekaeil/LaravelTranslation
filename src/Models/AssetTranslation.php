<?php

namespace Mekaeil\LaravelTranslation\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTranslation extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-translation.translation_style_table'));
    }

    protected $fillable = [
        'lang_id',      //  Language ID
        'type',         //  css_link, custom_css, script_link, custom_script
        'source',       //  value
        'where',        // front-end, back-end
        'status',       // true, false
        'path_type',    // app_path, resource_path, asset, url
    ];


    public function language(){
        return $this->belongsTo(FlagTranslation::class,'lang_id','id');
    }

}
