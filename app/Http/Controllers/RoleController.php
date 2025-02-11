<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    public function show($id)
    {
        return new RoleResource(Role::with('permissions')->find($id));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->only('name'));
        $role->permissions()->attach($request->input('permissions'));
        return response()->json(new RoleResource($role->load('permissions')), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update($request->only('name'));

        $role->permissions()->sync($request->input(('permissions')));

        return response()->json(new RoleResource($role->load('permisssions')), Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
