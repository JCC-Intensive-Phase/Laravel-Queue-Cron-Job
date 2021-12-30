<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request['name'];
        $product->price = $request['price'];
        $product->save();

        $addMedia = $product->addMediaFromRequest('img')->toMediaCollection('product-cols', 'products');

        $data['message'] = 'Berhasil';
        $data['data'] = $product;
        return response()->json($data, 200);
    }

    public function getAll()
    {
        $products = Product::all();
        $data['message'] = 'Berhasil';
        $data['data'] = $products;
        return response()->json($data, 200);
    }
}
