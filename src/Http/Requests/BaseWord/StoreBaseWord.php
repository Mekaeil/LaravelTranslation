<?php

namespace Mekaeil\LaravelTranslation\Http\Requests\BaseWord;

use Illuminate\Foundation\Http\FormRequest;

class StoreBaseWord extends FormRequest
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
            'key'   => 'required',
            'lang'  => 'required|numeric|exists:'. $table.',id',
            'value' => 'required'
        ];
    }
}
