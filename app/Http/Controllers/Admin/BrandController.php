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
            'banner'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        Cloudder::upload($request->file('banner'), null, array("folder" => "SneakerX/Brands/") );
        $cloundary_upload_banner = Cloudder::getResult();

        $brand = new Brand([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'banner' => $cloundary_upload_banner['url'],
//            'image' => $request->get('image'),
        ]);
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
