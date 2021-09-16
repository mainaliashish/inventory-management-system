<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PosController extends Controller
{

    public function getProduct($id) {
        $products = DB::table('products')->where('category_id', $id)->get();
        return response()->json($products);
    }

    public function processOrder(Request $request)
    {
        $validateData = $request->validate([
            'customer_id' => 'required',
            'pay_by' => 'required',
        ]);
        $data = array();
        $data['customer_id'] = $request->customer_id;
        $data['sub_total'] = $request->SubTotal;
        $data['product_quantity'] = $request->Quantity;
        $data['vat'] = $request->vat;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['pay_by'] = $request->pay_by;
        $data['total'] = $request->total;
        $data['order_day'] = date('d/m/Y');
        $data['order_month'] = date('M');
        $data['order_year'] = date('Y');
        $order_id = DB::table('orders')->insertGetId($data);
        $contents = DB::table('pos')->get();
        $order_details = array();

        foreach($contents as $content) {
            $order_details['order_id'] = $order_id;
            $order_details['product_id'] = $content->product_id;
            $order_details['product_quantity'] = $content->product_quantity;
            $order_details['product_price'] = $content->product_price;
            $order_details['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($order_details);

            DB::table('products')
                ->where('id', $content->product_id)
                ->update(['product_quantity' => DB::raw('product_quantity - '.$content->product_quantity)]);
        }

        DB::table('pos')->delete();
        return response() -> json(['status' => 'Success']);

    }
   
}
