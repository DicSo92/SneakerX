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
            $products = Product::orderBy('created_at', 'DESC')->with('brand')->paginate($nb);
        } else {
            $products = Product::orderBy('created_at', 'DESC')->with('brand')->paginate(8);
        }

        return response()->json($products);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @param              $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $slug)
    {
        $product = Product::where('slug', $slug)->firstorfail();
        return response()->json($product);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $search
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $search)
    {
        if (!$search) {
            return response()->json(["error" => true, "message" => "No query Search"], 400);
        }

        $nb = $request->query('nb');

        $searchProducts = Product::where('name', 'like', '%' . $search . '%')->with('brand')->paginate($nb);
        return response()->json($searchProducts);
    }
}
