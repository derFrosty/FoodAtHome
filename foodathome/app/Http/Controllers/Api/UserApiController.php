<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidationForm;
use App\Http\Requests\UpdatePasswordValidationForm;
use App\Http\Requests\UpdateUserValidationForm;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserApiController extends Controller
{
    public function index()
    {
        //
    }

    public function updateAvailability(Request $request)
    {

        $request_filter = $request->only('user_id', 'availability');

        $user_id = $request_filter["user_id"];
        $availability = $request_filter["availability"];



        $user = User::findOrFail($user_id);

        if($availability == 0){
            $user->available_at = null;
        }else{
            $user->available_at = Carbon::now();
        }

        $user->save();

        return response()->json(
            ['msg' => 'availability updated with success.'],
            200
        );
    }

    public function updateLoggedAt(Request $request)
    {

        $request_filter = $request->only('user_id', 'logged');

        $user_id = $request_filter["user_id"];
        $logged = $request_filter["logged"];



        $user = User::findOrFail($user_id);

        if($logged == 0){
            $user->logged_at = null;
        }else{
            $user->logged_at = Carbon::now();
        }

        $user->save();

        return response()->json(
            ['msg' => 'logged_at updated with success.'],
            200
        );
    }

    public function remove_avatar(Request $request){
        $user = User::with('customer')->where('id', $request->user()->id)->first();
        $user->photo_url = null;
        $user->save();

        return response()->json(
            ['msg' => 'User updated with success.',
                'user' => $user],
            200
        );
    }

    public function update_user(UpdateUserValidationForm $request){

        $avatar = $request->file('photo');

        $user = Auth::user();

        if($avatar != null){

            $filename = Storage::putFileAs('public/fotos', $request->photo, $user->id . time() . '.' . $avatar->getClientOriginalExtension());

            //devolvia não só o nome mas também o caminho, então removemos...
            $filename = substr($filename, strrpos($filename, '/')+1, strlen($filename));

            $user->photo_url = $filename;
        }


        $user->email = $request->email;

        $user->name = $request->fullname;

        $user->customer->address = $request->address;

        $user->customer->phone = $request->phone;

        $user->customer->nif = $request->nif;

        $user->save();

        return response()->json(
            ['msg' => 'User updated with success.',
             'user' => $user],
            200
        );
    }

    public function update_password(UpdatePasswordValidationForm $request){
        $user = Auth::user();

        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json(
            ['msg' => 'User updated with success.'],
            200
        );
    }
}
