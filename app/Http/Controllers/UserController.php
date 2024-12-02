<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function index()
    {
        return User::paginate();
    }

    public function show($id)
    {
        return User::find($id);
    }


    public function store(UserCreateRequest $request)
    {
        $users = User::create($request->only('first_name', 'last_name', 'email')
        + ['password'=>\Hash::make(123)]);
        return response()->json($users,Response::HTTP_CREATED);    
    }


    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response()->json($user, Response::HTTP_ACCEPTED);
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(NULL, Response::HTTP_NO_CONTENT);
    }
}
