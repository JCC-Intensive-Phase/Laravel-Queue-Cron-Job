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

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ])->addMediaFromRequest('image')->toMediaCollection('products', 's3');

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil!',
            'data' => $product
        ], 200);

        // $product = new Product();
        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->stock = $request->stock;

        // //save original file to AWS
        // $product->addMediaFromRequest('image')->toMediaCollection('products', 's3');

        // if (!$product->save()) {

        //     $response = [
        //         'message' => 'Gagal Menyimpan Data!',
        //         'data' => null,
        //     ];

        //     return response()->json($response, 400);
        // } else {
        //     $response = [
        //         'message' => 'Berhasil Menyimpan Data!',
        //     ];

        //     return response()->json($response, 200);
        // }
    }
}
