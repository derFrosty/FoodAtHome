<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordValidationForm extends FormRequest
{
    public function rules()
    {
        $rules = [];

        $rules = array_merge($rules, [
            'old_password' => ['required', 'string', 'password'],
            'password' => ['required', 'string', 'min:3', 'confirmed']
        ]);

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
