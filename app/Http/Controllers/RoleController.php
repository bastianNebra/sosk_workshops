<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return Role::all();
    }

    public function show($id){
        return Role::find($id);
    }

    public function store(Request $request){
        $role = Role::create($request->only('permission'));
        return response()->json($role,Response::HTTP_CREATED);
    }

    public function update(Request $request,$id){
        $role = Role::get($id);
        $role->update($request->only('name'));
        return response()->json($role,Response::HTTP_ACCEPTED);
    }

    public function delete($id){
        $role = Role::find($id);
        $role->delete();

        return response()->json(NULL, Request::HTTP_NO_CONTENT);
    }

}
