<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        //    return ProductResource::collection($products);

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'image' => 'nullable|string',
            'is_available' => 'boolean'
        ]);

        $product = Product::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }


    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully',
            'data' => $product
        ]);
    }
}
