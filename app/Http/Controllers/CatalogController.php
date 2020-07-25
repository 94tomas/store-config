<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('catalog');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $singleProduct = Product::where('slug', $slug)
            ->with('gallery')
            ->first();

        return response()->json($singleProduct, 200);
    }

    public function addItem($slug)
    {
        $selectProd = Product::select('id', 'slug', 'banner', 'name', 'price', 'discount')
            ->where('slug', $slug)
            ->first();
        $selectProd->quantity = 1;
        
        return response()->json($selectProd, 200);
    }
}
