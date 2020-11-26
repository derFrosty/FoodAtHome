<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidationForm extends FormRequest
{
    public function rules()
    {
        $rules = [];
        
    }

    public function authorize()
    {
        return true;
    }
}
