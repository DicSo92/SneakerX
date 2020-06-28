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
            'active' => 'required',
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
        $cloundary_upload = null;
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
        $product->active = json_decode($request->get('active'));
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
    public function update(Request $request, $id)
    {

    }
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'min:1|max:100',
        ]);

        if ($request->get('name')) $product->name = $request->get('name');
        if ($request->get('description')) $product->description = $request->get('description');
        if ($request->get('colors')) $product->colors = json_decode($request->get('colors'));
        if ($request->get('sizes')) $product->sizes = json_decode($request->get('sizes'));
        if ($request->get('active')) $product->active = json_decode($request->get('active'));
        if ($request->get('price')) $product->price = $request->get('price');
        if ($request->get('brandId')) $product->brand_id =  $request->get('brandId');

        $product->save();

        return response()->json($product);
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

    public function removeImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $imagesPath = env('CLOUDINARY_MAIN_FOLDER')."/Brands/";

        $imageId = pathinfo($product->image)['filename'];
        $imagePathId = $imagesPath . $imageId;
        Cloudder::destroyImage($imagePathId);
        Cloudder::delete($imagePathId);
        $product->image = null;

        $product->save();

        return response()->json($product);
    }

    public function addImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $brandName = $product->brand->name;
        $slug = $product->slug;

        $cloundary_upload_image = null;
        if ($request->hasFile('image')) {
            Cloudder::upload($request->file('image'), null, array("folder" => env('CLOUDINARY_MAIN_FOLDER')."/Products/".$brandName."/".$slug));
            $cloundary_upload_image = Cloudder::getResult();
        }

        if ($cloundary_upload_image) {
            $product->image = $cloundary_upload_image['url'];
        }

        $product->save();

        return response()->json($product);
    }

    public function removeImageFromImages(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'imgUrl' => 'required',
            'imagesArray' => 'required'
        ]);

        $imagesPath = env('CLOUDINARY_MAIN_FOLDER')."/Brands/";

        $imageId = pathinfo($request->get('imgUrl'))['filename'];
        $imagePathId = $imagesPath . $imageId;
        Cloudder::destroyImage($imagePathId);
        Cloudder::delete($imagePathId);

        $product->images = json_decode($request->get('imagesArray'));

        $product->save();

        return response()->json($product);
    }

    public function addImages(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'images' => 'required',
        ]);

        $brandName = $product->brand->name;
        $slug = $product->slug;

        $imagesArray = $product->images;
        $cloundary_upload = null;
        foreach($request->images as $image) {
            Cloudder::upload($image->getRealPath(), null, array("folder" => env('CLOUDINARY_MAIN_FOLDER')."/Products/".$brandName."/".$slug));
            $cloundary_upload = Cloudder::getResult();
            array_push($imagesArray, $cloundary_upload['url']);
        }

        $product->images = $imagesArray;

        $product->save();

        return response()->json($product);
    }
}
