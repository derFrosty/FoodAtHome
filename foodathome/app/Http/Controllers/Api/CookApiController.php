<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CookApiController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type != 'EC'){
            abort(403);
        }

        return 'boas';
    }
}
