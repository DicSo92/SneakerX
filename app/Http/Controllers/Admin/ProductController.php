<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
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
            'name' => 'required|unique:brands|max:80',
            'brandId' => 'required',
            'description' => 'max:750',
            'colors' => 'required',
            'sizes' => 'required',
            'price' => 'required',
            'image' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $brandName = Brand::find($request->get('brandId'))->name;
        $slug = Str::slug($request->get('name'), '-');

        $cloundary_upload_image = null;
        if ($request->hasFile('image')) {
            Cloudder::upload($request->file('image'), null, array("folder" => env('CLOUDINARY_MAIN_FOLDER')."/Products/".$brandName."/".$slug));
            $cloundary_upload_image = Cloudder::getResult();
        }

        $imagesArray = array();
        $cloundary_upload_images = null;
        foreach($request->images as $image) {
            Cloudder::upload($image->getRealPath(), null, array("folder" => env('CLOUDINARY_MAIN_FOLDER')."/Products/".$brandName."/".$slug));
            $cloundary_upload = Cloudder::getResult();
            array_push($imagesArray, $cloundary_upload['url']);
        }


        $product = new Product();

        $product->name = $request->get('name');
        $product->slug = $slug;
        $product->description = $request->get('description');
        $product->colors = json_decode($request->get('colors'));
        $product->sizes = json_decode($request->get('sizes'));
        $product->price = $request->get('price');
        $product->refLink = 'test';
        $product->brand_id =  $request->get('brandId');

        if ($cloundary_upload_image) {
            $product->image = $cloundary_upload_image['url'];
        }
        if (!empty($imagesArray)) {
            $product->images = $imagesArray;
        }

        $product->save();

        return response()->json($product);
    }
//    public function uploadImage(Request $request)
//    {
//        $request->validate([
//            'image' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
//            'name' => 'required|unique:brands|max:80',
//            'brandId' => 'required',
//            'productId' => 'required'
//        ]);
//        $product = Product::findOrFail($request->get('productId'));
//
//        $brandName = Brand::find($request->get('brandId'))->name;
//        $slug = Str::slug($request->get('name'), '-');
//
//        $imagesTable = is_null($product->images) ? array() : $product->images;
//
//        $cloundary_upload_image = null;
//        if ($request->hasFile('image')) {
//            Cloudder::upload($request->file('image'), null, array("folder" => env('CLOUDINARY_MAIN_FOLDER')."/Products/".$brandName."/".$slug));
//            $cloundary_upload_image = Cloudder::getResult();
//            array_push($imagesTable, $cloundary_upload_image['url']);
//        }
//
//        if ($cloundary_upload_image) {
//            $product->images = $imagesTable;
//        }
//
//        $product->save();
//
//
//        return response()->json($product);
//    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $brandId
     *
     * @return \Illuminate\Http\Response
     */
    public function productsPerBrand(Request $request, $brandId)
    {
        $products = Product::where('brand_id', $brandId)->orderBy('created_at', 'DESC')->with('brand')->get();

        return response()->json($products);
    }
}
