<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $qury = Product::query();
        if ($request->has('category_id')) {
            $qury->where('category_id', $request->category_id);
        }

        $products = $qury->paginate(10);
        //    return ProductResource::collection($products);
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }
}
