<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function register(RegisterRequest $request){
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),

        ]);
        Log::info("Create user with success", array("user"=>$user));
        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            return response([
                'error' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }
        /**
         *@var User $user
         */
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken; 

        return response()->json([
            'jwt'=>$token,
        ]);
    }

    public function user(Request $request){
        return $request->user();
    }
}
