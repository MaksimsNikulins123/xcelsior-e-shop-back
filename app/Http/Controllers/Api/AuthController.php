<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Exceptions\InvalidPasswordException;

class AuthController extends Controller
{
    public function getMessage() {
        return response()->json(
            [
                "message" => "Hello from API it's object message",
                "status_code" => 200
            ]
        );
    }


    public function signup(SignupRequest $request)
    {
        
        $data = $request->validated();
        $user = new User;
        $admins_array = [
            'arturs@xcelsior.lv',
            'zane@xcelsior.lv',
            'noliktava@xcelsior.lv'
        ];
        $managers_array = [
            'jana@xcelsior.lv',
            'janis@xcelsior.lv',
            'rita@xcelsior.lv',
        ];
        $response = [];

        if(in_array($data['email'], $admins_array ))
        {
                $user->create([
                'rights' => 'admin',
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Crypt::encryptString($data['password']),
                'user_location' => $data['user_location'],
                'remember_me' => false
                ]);
                $this->response = [
                    'status' => 200,
                    'message' => 'Signup seccess',
                ];
            

        }else if(in_array($data['email'], $managers_array) ) {
            $user->create([
                'rights' => 'manager',
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Crypt::encryptString($data['password']),
                'user_location' => $data['user_location'],
                'remember_me' => false
            ]);
            $this->response = [
                'status' => 200,
                'message' => 'Signup seccess',
            ];
        }else{
            $this->response = [
                'status' => 200,
                'message' => 'The selected email is invalid.',
            ];
        }

        return response()->json($this->response);
    }

    public function login(LoginRequest $request)
    {
        $response = [];
        $data = $request->validated();

        $user = new User;
        $login_user_id = $user->select('id')->where('email', $request->email)->first();
        $signedup_user_info = $user->find($login_user_id)->first();
        // $token = get_user_by_id


        if($request->password == Crypt::decryptString($signedup_user_info->password)){
            $this->response = [
                'status' => 200,
                'message' => 'Login seccess',
                'rights' => $signedup_user_info->rights,
                // 'token' => $signedup_user_info->createToken('Token name')->accessToken
            ];
        }else{
            throw new InvalidPasswordException;
        }

        return response()->json($this->response);
   }
}