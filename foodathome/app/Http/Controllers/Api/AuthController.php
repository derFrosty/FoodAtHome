<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Client\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        dd("AQUI0!");
        $credentials = $request->only('email', 'password');
        dd("AQUI1!");
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            dd("AQUI2!");

            return response()->json(
                ['msg'=>'Authenticated with success.'],
                200
            );
        }
    }
}
