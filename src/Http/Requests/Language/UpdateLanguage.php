<?php

namespace Mekaeil\LaravelTranslation\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguage extends FormRequest
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
        return [
            'display_name'  => 'required',
            'status'        => 'nullable',
            'direction'     => 'required|in:ltr,rtl',
            //  'default'       => 'nullable',
        ];
    }
}
