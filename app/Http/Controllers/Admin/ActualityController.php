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
