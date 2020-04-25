<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Brand;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:brands|max:80',
            'description'=>'required|unique:brands|max:255',
            'banner'=>'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'image'=>'mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $cloundary_upload_banner = null;
        if ($request->hasFile('banner')) {
            Cloudder::upload($request->file('banner'), null, array("folder" => "SneakerX/Brands/") );
            $cloundary_upload_banner = Cloudder::getResult();
        }
        $cloundary_upload_image = null;
        if ($request->hasFile('image')) {
            Cloudder::upload($request->file('image'), null, array("folder" => "SneakerX/Brands/") );
            $cloundary_upload_image = Cloudder::getResult();
        }

        $brand = new Brand();

        $brand->name = $request->get('name');
        $brand->description = $request->get('description');

        if ($cloundary_upload_banner) {
            $brand->banner = $cloundary_upload_banner['url'];
        }
        if ($cloundary_upload_image) {
            $brand->image = $cloundary_upload_image['url'];
        }

        $brand->save();

        return response()->json($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json($brand);
    }
}
