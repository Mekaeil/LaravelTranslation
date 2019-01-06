<?php

namespace Mekaeil\LaravelTranslation\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table = config('laravel-translation.translation_flags_table');

        return [
            'name'          => 'required|min:2|unique:'. $table,
            'display_name'  => 'required',
            'status'        => 'nullable',
            //'default'       => 'nullable',
        ];
    }
}
