<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    public function show($id)
    {
        return new PermissionResource(Permission::find($id));
    }

    public function store(Request $request)
    {
        $permission = Permission::create($request->only('permission'));

        return response()->json(new PermissionResource($permission), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::get($id);
        $permission->update($request->only('name'));

        return response()->json(new PermissionResource($permission), Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
