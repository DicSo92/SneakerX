<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Actuality;
use Illuminate\Http\Request;

class ActualityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nb = $request->query('nb');

        if (isset($nb)) {
            $actualities = Actuality::orderBy('published_date', 'DESC')->with('user')->paginate($nb);
        } else {
            $actualities = Actuality::orderBy('published_date', 'DESC')->with('user')->paginate(8);
        }

        return response()->json($actualities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Actuality $actuality
     * @param                $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Actuality $actuality, $slug)
    {
        $actuality = Actuality::where('slug', $slug)->firstorfail();
        return response()->json($actuality);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actuality  $actuality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actuality $actuality)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actuality  $actuality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actuality $actuality)
    {
        //
    }
}
