<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
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
            'role_id' =>1,

        ]);
        Log::info("Create user with success", array("user"=>$user));
        return response(new UserResource($user), Response::HTTP_CREATED);
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
        $jwt = $user->createToken('token')->plainTextToken; 

        $cookie = cookie('jwt', $jwt,24*60*60);

        return response()->json([
            'jwt'=>$jwt,
        ])->withCookie($cookie);
    }

    public function user(Request $request){
        $user = $request->user();
        return new UserResource($user->load('role')) ;
    }

    public function logout(Request $request){

        $cookie = \Cookie::forget('jwt');
        return \response([
            'message' => 'Logged out successfully'
        ])->withoutCookie($cookie);
    }


    public function updateInfo(UpdateInfoRequest $request){
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response()->json($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request){
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);

    }
}
