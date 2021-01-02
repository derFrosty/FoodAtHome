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
            'password' => ['required', 'string', 'password'],
            'address' => ['string', 'max:255'],
            'phone' => ['string', 'between:9,20'],
            'nif' => ['string', 'digits:9'],
            'photo' => ['nullable', 'image', 'max:5000']
        ]);

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
