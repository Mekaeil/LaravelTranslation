<?php

namespace Mekaeil\LaravelTranslation\Models;

use Illuminate\Database\Eloquent\Model;

class BaseTranslation extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-translation.translation_base_table'));
    }

    protected $fillable = [
        'key',      // unique and find words with it
        'value',    // value of the words
        'lang',     //  id for Relation to flags table
        'locale',   // languages string like, en, fa , ...
    ];


}
