<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOrderRequest extends FormRequest
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
            "orderNotes" => "nullable",
            "products" => "required|array",
            "products.*.id" => "required|integer|exists:products,id",
            "products.*.quantity" => "required|integer|min:1"
        ];
    }
}
