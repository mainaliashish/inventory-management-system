<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')
                        ->join('categories', 'products.category_id', 'categories.id')
                        ->join('suppliers', 'products.supplier_id', 'suppliers.id')
                        ->select('categories.category_name', 'suppliers.name', 'products.*')
                        ->orderBy('products.id', 'DESC')
                        ->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_id' => 'required',
            'product_name' => 'required|max:155',
            'product_code' => 'unique:products',
            'root' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'supplier_id' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required'
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $image = Image::make($request->photo)->resize(240,200);
               // Be Sure to Create Produts folder else getting undefined Name Error
            $upload_path = 'backend/products/';
            $image_url = $upload_path.$name;

            $image->save($image_url);

        } else {
            $image_url = '';
        }
        $product = new Product();
        
        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->root = $request->root;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->supplier_id = $request->supplier_id;
        $product->buying_date = $request->buying_date;
        $product->photo = $image_url;
        $product->product_quantity = $request->product_quantity;
        $product->save();
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return response()->json($product);
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
        $validateData = $request->validate([
            'category_id' => 'required',
            'product_name' => 'required|max:155',
            'product_code' => 'required',
            'root' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'supplier_id' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required'
        ]);

        $data = array();
        $data['category_id'] =  $request->category_id;
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['root'] = $request->root;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['supplier_id'] = $request->supplier_id;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        $image = $request->new_photo;
        if($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $image = Image::make($image)->resize(240,200);
            $upload_path = 'backend/products/';
            $image_url = $upload_path.$name;

            $result = $image->save($image_url);
            if($result) {
                $data['photo'] = $image_url;
                $img = DB::table('products')->where('id', $id)->first();
                $image_path = $img->photo;
                $res = unlink($image_path);
            }
        } else {
            $data['photo'] = $request->photo;
        }
        DB::table('products')->where('id', $id)->update($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $photo = $product->photo;
        if($photo) {
            unlink($photo);
        }
        DB::table('products')->where('id', $id)->delete();

        return response()->json(['status' => 'Success']);
    }

    public function updateStock(Request $request, $id)
    {
        $data = array();
        $data['product_quantity'] = $request->product_quantity;
        DB::table('products')->where('id', $id)->update($data);
        
    }



}
