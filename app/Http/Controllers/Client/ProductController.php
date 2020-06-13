<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nb = $request->query('nb');

        if (isset($nb)) {
            $tasks = Product::orderBy('created_at', 'DESC')->with('brand')->paginate($nb);
        } else {
            $tasks = Product::orderBy('created_at', 'DESC')->with('brand')->paginate(8);
        }

        return response()->json($tasks);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $slug)
    {
        $product = Product::where('slug', $slug)->firstorfail();
        return response()->json($product);
    }
}
