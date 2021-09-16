<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    public function addToCart(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        $cart = DB::table('pos')->where('product_id', $id)->first();
        if($cart) {
             DB::table('pos')->where('product_id', $id)->increment('product_quantity');
             $product = DB::table('pos')->where('product_id', $id)->first();
             $sub_total = $product->product_quantity * $product->product_price;
             DB::table('pos')->where('product_id', $id)->update(['sub_total'=> $sub_total]);
        } else {

        $data = array();
        $data['product_id'] = $id;
        $data['product_name'] = $product->product_name;
        $data['product_quantity'] = 1;
        $data['product_price'] = $product->selling_price;
        $data['sub_total'] = $product->selling_price;

        DB::table('pos')->insert($data);
        }

    }

    public function cartProducts()
    {
        $carts = DB::table('pos')->get();
        return response()->json($carts);
    }

    public function removeCart($id){
        DB::table('pos')->where('id', $id)->delete();
    }

    public function incrementCart($id)
    {
        $cart = DB::table('pos')->where('id', $id)->first();
        if($cart) {
            DB::table('pos')->where('id', $id)->increment('product_quantity');
            $product = DB::table('pos')->where('id', $id)->first();
            $sub_total = $product->product_quantity * $product->product_price;
            DB::table('pos')->where('id', $id)->update(['sub_total'=> $sub_total]);
            return response() -> json('Success');
        }

    }

    public function decrementCart($id)
    {
        $cart = DB::table('pos')->where('id', $id)->first();
        if($cart->product_quantity > 1) {
            DB::table('pos')->where('id', $id)->decrement('product_quantity');
            $product = DB::table('pos')->where('id', $id)->first();

            $sub_total = $product->sub_total - $product->product_price;
            DB::table('pos')->where('id', $id)->update(['sub_total'=> $sub_total]);
         return response() -> json('Success');
        } else {
            $this->removeCart($id);
        }
    }

    public function getVat()
    {
        $vat = DB::table('extra')->first();
        return response() -> json($vat);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
