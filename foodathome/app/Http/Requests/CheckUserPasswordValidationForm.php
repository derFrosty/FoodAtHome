<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckUserPasswordValidationForm extends FormRequest
{
    public function rules()
    {
        $rules = [];

        $rules = array_merge($rules, [
            'password' => ['required', 'string', 'password']
        ]);

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
