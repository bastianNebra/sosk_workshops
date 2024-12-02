<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index(){
        return Permission::all();
    }

    public function show($id){
        return Permission::find($id);
    }

    public function store(Request $request){
        $permission = Permission::create($request->only('permission'));
        return response()->json($permission,Response::HTTP_CREATED);
    }

    public function update(Request $request,$id){
        $permission = Permission::get($id);
        $permission->update($request->only('name'));
        return response()->json($permission,Response::HTTP_ACCEPTED);
    }

    public function delete($id){
        $permission = Permission::find($id);
        $permission->delete();

        return response()->json(NULL, Request::HTTP_NO_CONTENT);
    }


}
