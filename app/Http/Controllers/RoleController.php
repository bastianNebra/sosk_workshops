<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index(){
        return RoleResource::collection( Role::all());
    }

    public function show($id){
        return new RoleResource(Role::with('permissions')->find($id));
    }

    public function store(Request $request){
        $role = Role::create($request->only('permission'));
        return response()->json(new RoleResource($role),Response::HTTP_CREATED);
    }

    public function update(Request $request,$id){
        $role = Role::get($id);
        $role->update($request->only('name'));
        return response()->json(new RoleResource($role),Response::HTTP_ACCEPTED);
    }

    public function delete($id){
        $role = Role::find($id);
        $role->delete();

        return response()->json(NULL, Response::HTTP_NO_CONTENT);
    }

}
