<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'address',
        'phone',
        'nif'
    ];

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'digits_between:9,20'],
            'nif' => ['required', 'string', 'digits_between:9,9']
        ]);
    }
}
