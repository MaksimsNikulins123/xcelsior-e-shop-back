<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $user = new Users;
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
                'password' => bcrypt($data['password']),
                'user_location' => $data['user_location']
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
                'password' => bcrypt($data['password']),
                'user_location' => $data['user_location']
            ]);
            $this->response = [
                'status' => 200,
                'message' => 'Signup seccess',
            ];
        }else{
            $this->response = [
                'status' => 200,
                'message' => 'Signup error',
            ];
        }

        return response()->json($this->response);
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();
       
        // if(!Auth::attempt($credentials)){
        //     return response()->json([
        //         'status' => 401,
        //         'message' => 'Unauthorized'
        // ]);
        // }

        // $user = Auth::user();
        // $token = $user->createToken('main')->plainTextToken;
        // return response()->json([
        //     'status' => 200,
        //     'message' => 'Login validation seccess',
        //     'user' => $user,
        //     'token' => $token
        // ]);
        $response = [
            'status' => 200,
            'message' => 'Login validation seccess',
            // 'credentials' => $credentials
        ];

        return response()->json($response);
   }
}