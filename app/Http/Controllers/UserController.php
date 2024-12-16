<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::paginate());
    }
    public function show($id)
    {
        return new UserResource(User::with('role')->find($id));
    }


    public function store(UserCreateRequest $request)
    {
        $users = User::create($request->only('first_name', 'last_name', 'email', 'role_id')
        + ['password' => \Hash::make(123)]);
        return response()->json(new UserResource($users), Response::HTTP_CREATED);
    }


    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
