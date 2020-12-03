<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserValidationForm extends FormRequest
{
    public function rules()
    {
        $rules = [];

        $rules = array_merge($rules, [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:3'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'digits_between:9,20'],
            'nif' => ['required', 'string', 'digits:9'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg']
        ]);

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
