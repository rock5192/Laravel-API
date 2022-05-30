<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
               'errors' => $validator->errors()
            ],422);
        }

        $requestData['password'] = Hash::make($requestData['password']);
        $user = User::create($requestData);
        $token = $user->createToken('token')->accessToken;



        return response([
            'status' => true,
            'message' => 'User successfully registered',
            'token' => $token

        ],200);
    }

    public function login(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
           'email' => 'email|required',
           'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }

        if(!Auth::attempt($requestData))
        {
            return response()->json(['errors' => 'Unauthorized access'], 401);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;


        return [
            'data' => new UserResource(auth()->user()),
            'token' => $accessToken
        ];
    }

    public function me()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    public function logout(Request $request)
    {
        $token = $request->user->token();
        $token->revoke();
        return response([
            'message' => 'You have been successfully logged out !'
        ],200);
    }
}
