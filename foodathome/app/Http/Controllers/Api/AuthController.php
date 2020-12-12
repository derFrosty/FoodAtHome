<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidationForm;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if(!$user){
            return response()->json(
                ['error'=>'Email not found!'],
                404
            );
        }

        if (Auth::attempt($credentials)) {
            // Authentication passed...

            if($user->blocked){
                $this->logout();

                return response()->json(
                    ['error'=>'Your account is blocked.'],
                    423
                );
            }

            return response()->json(
                ['msg'=>'Authenticated with success.'],
                200
            );
        }else{
            return response()->json(
                ['error'=>'Could not authenticate.'],
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

    public function register(RegisterValidationForm $request)
    {
        $registration = $request->only('fullname', 'password', 'email', 'photo_url', 'password_confirmation', 'type', 'address', 'phone', 'nif');

        $transation_result = DB::transaction(function () use ($registration) {
            $user = User::create([
                'name' => $registration['fullname'],
                'password' => Hash::make($registration['password']),
                'email' => $registration['email'],
                'photo_url' => isset($registration['photo_url']) ? $registration['photo_url'] : null
            ]);

            $customer = Customer::create([
                'id' => $user->id,
                'address' => $registration['address'],
                'nif' => $registration['nif'],
                'phone' => $registration['phone']
            ]);

        });



        $user = User::where('email', $registration['email'])->first();

        $avatar = $request->file('photo');

        if($avatar != null){

            $filename = Storage::putFileAs('public/fotos', $request->photo, $user->id . time() . '.' . $avatar->getClientOriginalExtension());

            //devolvia não só o nome mas também o caminho, então removemos...
            $filename = substr($filename, strrpos($filename, '/')+1, strlen($filename));

            $user->photo_url = $filename;

            $user->save();
        }





        return response()->json(
            ['msg'=>'Registered with success!'],
            201
        );
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }


}
