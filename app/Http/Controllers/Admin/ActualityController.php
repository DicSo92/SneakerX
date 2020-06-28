<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Actuality;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;

class ActualityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = Actuality::all();
        return response()->json($news);
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
            'title' => 'required|unique:actualities|max:120',
            'subtitle' => 'required',
            'content' => 'required|max:2000',
            'refLink' => 'max:2000',
            'published' => 'required',
            'image' => 'mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $slug = Str::slug($request->get('title'), '-');

        $cloundary_upload_image = null;
        if ($request->hasFile('image')) {
            Cloudder::upload($request->file('image'), null, array("folder" => env('CLOUDINARY_MAIN_FOLDER')."/Actualities/"));
            $cloundary_upload_image = Cloudder::getResult();
        }

        $actuality = new Actuality();

        if ($request->get('refLink')) $actuality->refLink = $request->get('refLink');

        $actuality->slug = $slug;
        $actuality->user_id = auth()->user()->id;
        $actuality->title = $request->get('title');
        $actuality->subtitle = $request->get('subtitle');
        $actuality->content = $request->get('content');
        $actuality->published = json_decode($request->get('published'));

        if ($cloundary_upload_image) {
            $actuality->image = $cloundary_upload_image['url'];
        }

        $actuality->save();

        return response()->json($actuality);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actuality  $actuality
     * @return \Illuminate\Http\Response
     */
    public function show(Actuality $actuality, $id)
    {
        $product = Actuality::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Actuality $actuality
     *
     * @return void
     */
    public function destroy(Actuality $actuality)
    {
        //
    }
}
