<?php

namespace Mekaeil\LaravelTranslation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class FlagTranslation extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-translation.translation_flags_table'));
    }

    protected $fillable = [
        'name',             // key for language
        'display_name',     // name of language for display
        'status',           // boolean ( default = true )
        'default',          // boolean ( default = false )
    ];




}
