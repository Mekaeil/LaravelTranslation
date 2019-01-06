<?php

namespace Mekaeil\LaravelTranslation\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleTranslation extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-translation.translation_module_table'));
    }

    protected $fillable = [
        'key',              // unique and find sentence with it
        'value',            // value of the words and sentences
        'lang_id',          // Relation to languages list in flags table
        'locale',           // en, fa, ...
        'translable_id',    // integer
        'translable_type',  // string
    ];



}
