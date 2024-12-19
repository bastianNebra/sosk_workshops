<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function show($id)
    {
        return new ProductResource(Product::find($id));
    }

    public function store(Request $request)
    {
        $Product = Product::create($request->only('title', 'description', 'image', 'price'));
        return response()->json(new ProductResource($Product), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $Product = Product::find($id);
        $Product->update($request->only('title', 'description', 'image', 'price'));
        return response()->json(new ProductResource($Product), Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        Product::destroy($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
