<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Product;
use App\Gallery;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexProduct = Product::select('id', 'name', 'banner', 'price', 'discount', 'qualification', 'slug')
            ->where('publish', true)
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        return response()->json($indexProduct, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataProduct = Product::select('id', 'name', 'banner', 'publish')
            ->orderBy('created_at', 'DESC')
            ->paginate(6);

        return response()->json($dataProduct, 200);
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
            'name' => 'required|unique:products',
            'description' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|numeric|min:0',
            'price' => 'required',
            'discount' => 'numeric|min:0',
            'category_id' => 'required',
        ]);

        $product = new Product;
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->stock = $request['stock'];
        $product->price = $request['price'];
        $product->discount = $request['discount'];
        $product->category_id = $request['category_id'];
        $product->publish = $request['publish'];
        if ($request->file('banner')) {
            $file = $request->file('banner');
            $upload_path = public_path('images/banners');
            $fileName = 'img_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $fileName);
            $product->banner = $fileName;
        }
        $product->slug = Str::slug($request['name'], '-');
        $product->save();

        $galleries = $request->file('gallery');
        if($request->hasFile('gallery'))
        {
            foreach ($galleries as $key => $item) {
                $upload_path = public_path('images/galleries');
                $imgName = 'img_' . $key . time() . '.' . $item->getClientOriginalExtension();
                $item->move($upload_path, $imgName);
                \DB::insert('insert into galleries (image, product_id) values (?, ?)', [$imgName, $product->id]);
            }
        }

        return response()->json(['msg' => 'ok'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showProduct = Product::where('id', $id)
            ->with('gallery')
            ->first();

         return response()->json($showProduct, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'description' => 'required',
            // 'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|numeric|min:0',
            'price' => 'required',
            'discount' => 'numeric|min:0',
            'category_id' => 'required',
        ]);

        $upProduct = Product::find($id);
        $upProduct->name = $request['name'];
        $upProduct->description = $request['description'];
        $upProduct->stock = $request['stock'];
        $upProduct->price = $request['price'];
        $upProduct->discount = $request['discount'];
        $upProduct->category_id = $request['category_id'];
        $upProduct->publish = $request['publish'];
        if ($request->file('banner')) {
            $file = $request->file('banner');
            $upload_path = public_path('images/banners');
            $fileName = 'img_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $fileName);
            // Delete old image
            if (file_exists(base_path('/public/images/banners/') . $upProduct->banner)) {
                unlink(base_path('/public/images/banners/') . $upProduct->banner);
            }
            $upProduct->banner = $fileName;
        }
        $upProduct->slug = Str::slug($request['name'], '-');
        $upProduct->save();

        // Gallery
        $delGallery = array();
        $arrayGallery = Gallery::where('product_id', $id)->get();
        if ($request['gallery']) {
            foreach ($arrayGallery as $item) {
                if (!in_array($item->image, $request->gallery)) {
                    array_push($delGallery, $item);
                }
            }
        } else {
            $delGallery = $arrayGallery;
        }
        foreach ($delGallery as $value) {
            Gallery::where('id', $value->id)->delete();
            // Delete old image
            if (file_exists(base_path('/public/images/galleries/') . $value->image)) {
                unlink(base_path('/public/images/galleries/') . $value->image);
            }
        }

        if($request->hasFile('gallery'))
        {
            $galleries = $request->file('gallery');
            foreach ($galleries as $key => $item) {
                $upload_path = public_path('images/galleries');
                $imgName = 'img_' . $key . time() . '.' . $item->getClientOriginalExtension();
                $item->move($upload_path, $imgName);
                \DB::insert('insert into galleries (image, product_id) values (?, ?)', [$imgName, $id]);
            }
        }
        /* $galleries = $request->file('gallery');
        if($request->hasFile('gallery'))
        {
            foreach ($galleries as $key => $item) {
                $upload_path = public_path('images/galleries');
                $imgName = 'img_' . $key . time() . '.' . $item->getClientOriginalExtension();
                $item->move($upload_path, $imgName);
                \DB::insert('insert into galleries (image, product_id) values (?, ?)', [$imgName, $product->id]);
            }
        } */

        return response()->json(['msg' => 'ok'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delProduct = Product::find($id);
        // Delete old image
        if (file_exists(base_path('/public/images/banners/') . $delProduct->banner)) {
            unlink(base_path('/public/images/banners/') . $delProduct->banner);
        }
        
        // Gallery
        $arrayGallery = Gallery::where('product_id', $id)->get();
        foreach ($arrayGallery as $value) {
            // Delete old image
            if (file_exists(base_path('/public/images/galleries/') . $value->image)) {
                unlink(base_path('/public/images/galleries/') . $value->image);
            }
        }
        $delProduct->delete();
        
        return response()->json(['msg' => 'ok'], 200);
    }
}
