<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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
        }
    }


    public function register(Request $request)
    {
        $registration = $request->only('fullname', 'password', 'email', 'photo_url', 'password_confirmation', 'type');


        $validator = User::validator($registration);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ]);
        }

        event(new Registered($user = $this->create($registration)));

        //código para tratar depois da foto do utilizador


//        if ($request->foto_perfil != null) {
//            $filename = Storage::putFile('public/fotos_utilizador', $request->foto_perfil);
//
//            //devolvia não só o nome mas também o caminho, então removemos...
//            $filename = substr($filename, strrpos($filename, '/')+1, strlen($filename));
//
//            $user->foto_perfil = $filename;
//            //fim guardar imagem
//            $user->save();
//        }


        return response()->json(
            ['msg'=>'Registered with success!'],
            200
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
