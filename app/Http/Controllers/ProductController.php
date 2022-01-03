<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return response()->json([
            'message'=>'success',
            'data'=>Product::all()
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name'=>'required',
            'product_price'=>'required|numeric',
            'image'=>'required|mimes:jpg,png,jpeg'
        ]);
        try {
            // original
            $original_image = $request->image->store('/images','s3','public');
            $original_url = Storage::disk('s3')->url($original_image);

            // convert to large
            $image_resize_large = Image::make($request->image);
            $image_resize_large->resize(1024,600)->stream();

            $large_image = 'large'.$request->image->getClientOriginalName();

            Storage::disk('s3')->put('images/'.$large_image, $image_resize_large);
            $large_url = Storage::disk('s3')->url('images/'.$large_image);


            // convert to medium
            $image_resize_medium = Image::make($request->image);
            $image_resize_medium->resize(800,400)->stream();


            $medium_image = 'medium'.$request->image->getClientOriginalName();

            Storage::disk('s3')->put('images/'.$medium_image, $image_resize_medium);
            $medium_url = Storage::disk('s3')->url('images/'.$medium_image);

            // convert to small
            $image_resize_small = Image::make($request->image);
            $image_resize_small->resize(215,80)->stream();

            $small_image = 'small'.$request->image->getClientOriginalName();
            // $small_url = 'images/'.$small_image;
            // $image_resize_small->save(public_path($small_url));

            Storage::disk('s3')->put('images/'.$small_image, $image_resize_small);
            $small_url = Storage::disk('s3')->url('images/'.$small_image);


            $product = Product::create([
                'product_name'=>$request->product_name,
                'product_price'=>$request->product_price,
                'original_image_name'=>basename($original_image),
                'original_image_url'=>$original_url,
                'large_image_name'=>basename($large_image),
                'large_image_url'=>$large_url,
                'medium_image_name'=>basename($medium_image),
                'medium_image_url'=>$medium_url,
                'small_image_name'=>basename($small_image),
                'small_image_url'=>$small_url,
            ]);
            return response()->json([
                'message'=>'success',
                'data'=>$product
            ],201);
        } catch (\Throwable $th) {
            // return $th;
            return response()->json([
                'message'=>'failed',
                'data'=>$th
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return Storage::disk('s3')->response('images/' . $product->original_image_name);
        return response()->json([
            'message'=>'success',
            'data'=>$product
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            //code...
            Storage::disk('s3')->delete($product->original_image_name);
            Storage::disk('s3')->delete($product->large_image_name);
            Storage::disk('s3')->delete($product->medium_image_name);
            Storage::disk('s3')->delete($product->small_image_name);
            $product->delete();
            return response()->json([
                'message'=>'success'
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message'=>'failed'
            ],400);
        }
    }
}
