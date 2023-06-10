<?php

namespace App\Exceptions;

use Exception;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvalidPasswordException extends Exception
{
    public function report(): void 
    {
        //
    }

    public function render(Request $request)
    {
        return response()->json([
            'message' => 'Password is invalid',
            'status' => 401
        ], 401);
    }
}