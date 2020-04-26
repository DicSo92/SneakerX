<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Brand;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use function GuzzleHttp\Psr7\copy_to_string;

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
            'name' => 'required|unique:brands|max:80',
            'description' => 'max:750',
            'banner' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'image' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $cloundary_upload_banner = null;
        if ($request->hasFile('banner')) {
            Cloudder::upload($request->file('banner'), null, array("folder" => "SneakerX/Brands/"));
            $cloundary_upload_banner = Cloudder::getResult();
        }
        $cloundary_upload_image = null;
        if ($request->hasFile('image')) {
            Cloudder::upload($request->file('image'), null, array("folder" => "SneakerX/Brands/"));
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
     * @param \App\Brand $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Brand               $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }
    public function updateBrand(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'unique:brands|min:1|max:80',
            'description' => 'max:750',
            'banner' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            'image' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        if ($request->get('name')) {
            $brand->name = $request->get('name');
        }
        if ($request->get('description')) {
            $brand->description = $request->get('description');
        }

        $imagesPath = "SneakerX/Brands/";
        $cloundary_upload_banner = null;
        if ($request->hasFile('banner')) {
            if (!is_null($brand->banner)) {
                $bannerId = pathinfo($brand->banner)['filename'];
                $bannerPathId = $imagesPath . $bannerId;
                Cloudder::destroyImage($bannerPathId);
                Cloudder::delete($bannerPathId);
            }

            Cloudder::upload($request->file('banner'), null, array("folder" => "SneakerX/Brands/"));
            $cloundary_upload_banner = Cloudder::getResult();
        }
        $cloundary_upload_image = null;
        if ($request->hasFile('image')) {
            if (!is_null($brand->image)) {
                $imageId = pathinfo($brand->image)['filename'];
                $imagePathId = $imagesPath . $imageId;
                Cloudder::destroyImage($imagePathId);
                Cloudder::delete($imagePathId);
            }

            Cloudder::upload($request->file('image'), null, array("folder" => "SneakerX/Brands/"));
            $cloundary_upload_image = Cloudder::getResult();
        }


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
     * Remove the specified resource from storage.
     *
     * @param \App\Brand $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $imagesPath = "SneakerX/Brands/";
        $imagesArrayId = array();

        if (!is_null($brand->banner)) {
            $bannerId = pathinfo($brand->banner)['filename'];
            array_push($imagesArrayId, $imagesPath . $bannerId);
        }
        if (!is_null($brand->image)) {
            $imageId = pathinfo($brand->image)['filename'];
            array_push($imagesArrayId, $imagesPath . $imageId);
        }

        $brand->delete();

        if (!empty($imagesArrayId)) {
            $delete = Cloudder::destroyImages($imagesArrayId);

            return response()->json(array('images' => $delete, 'brand' => $brand));
        } else {
            return response()->json($brand);
        }
    }

    public function removeImage(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $imagesPath = "SneakerX/Brands/";

        if (!is_null($brand->banner) AND $request->query('type') === 'banner') {
            $bannerId = pathinfo($brand->banner)['filename'];
            $bannerPathId = $imagesPath . $bannerId;
            Cloudder::destroyImage($bannerPathId);
            Cloudder::delete($bannerPathId);
            $brand->banner = null;
        }
        if (!is_null($brand->image) AND $request->query('type') === 'image') {
            $imageId = pathinfo($brand->image)['filename'];
            $imagePathId = $imagesPath . $imageId;
            Cloudder::destroyImage($imagePathId);
            Cloudder::delete($imagePathId);
            $brand->image = null;
        }

        $brand->save();

        return response()->json($brand);
    }
}
