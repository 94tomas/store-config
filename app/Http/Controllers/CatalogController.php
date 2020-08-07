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
    public function index(Request $request)
    {
        $byCat = $request['cat'];
        $byTitle = $request['title'];

        /* $dataProduct = Product::select()
            ->with('category')
            ->with(array('attribute' => function($q) {
                $q->select('name', 'attribute');
            }))
            ->orderBy('created_at', 'DESC')
            ->paginate(6); */

        $dataProduct = Product::select()
            ->with('category')
            ->whereHas('category', function($x) use($byCat) {
                if ($byCat !== 'all') {
                    $x->where('id', $byCat);
                }
            })
            ->where('name', 'like', '%'.$byTitle.'%')
            ->with(array('attribute' => function($q) {
                $q->select('name', 'attribute');
            }))
            ->orderBy('created_at', 'DESC')
            ->paginate(9);

        return response()->json($dataProduct, 200);
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
            ->with(array('attribute' => function($q) {
                $q->select('name', 'attribute');
            }))
            ->where('publish', 1)
            ->first();

        return response()->json($singleProduct, 200);
    }

    public function addItem($slug)
    {
        $selectProd = Product::select('id', 'slug', 'banner', 'name', 'price', 'discount')
            ->where('slug', $slug)
            /* ->with(array('attribute' => function($q) {
                $q->select('name', 'attribute');
            })) */
            ->first();
        $selectProd->quantity = 1;
        $selectProd->attr = null;
        /* if (count($selectProd->attribute) !== 0) {
            $selectProd->attr = $selectProd->attribute[0]->attribute;
        } else {
            $selectProd->attr = null;
        } */
        
        return response()->json($selectProd, 200);
    }
}
