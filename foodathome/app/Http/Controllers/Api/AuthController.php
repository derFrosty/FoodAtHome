<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...

            return response()->json(
                ['msg'=>'Authenticated with success.'],
                200
            );
        }else{
            return response()->json(
                ['msg'=>'Could not authenticate.'],
                401
            );
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return response()->json(
            ['msg' => 'User logged out with success.'],
            200
        );
    }

}
