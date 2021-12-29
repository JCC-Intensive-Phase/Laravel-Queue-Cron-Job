<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|file|max:2048'
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
            ];
            return response()->json($response, 400);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        $product->addMediaFromRequest('image')->toMediaCollection('products');
    }
}
