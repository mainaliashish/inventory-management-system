<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
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
            'name' => 'required|unique:suppliers|max:150',
            'email' => 'required',
            'phone'   => 'required|max:150'
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $image = Image::make($request->photo)->resize(240,200);
            // Be Sure to Create Suppliers folder else getting undefined Name Error
            $upload_path = 'backend/suppliers/';
            $image_url = $upload_path.$name;

            $image->save($image_url);

        } else {
            $image_url = '';
        }
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->shopname = $request->shopname;
        $supplier->photo = $image_url;
        $supplier->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        return response()->json($supplier);
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
            'name' => 'required|max:150',
            'email' => 'required|max:150',
            'phone'   => 'required|max:150'
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['shopname'] = $request->shopname;
        // $data['photo'] = $request->new_photo;
        $image = $request->new_photo;
        if($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $image = Image::make($image)->resize(240,200);
            $upload_path = 'backend/suppliers/';
            $image_url = $upload_path.$name;

            $result = $image->save($image_url);
            if($result) {
                $data['photo'] = $image_url;
                $img = DB::table('suppliers')->where('id', $id)->first();
                $image_path = $img->photo;
                $res = unlink($image_path);
            }
        } else {
            $data['photo'] = $request->photo;
        }
        DB::table('suppliers')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        $photo = $supplier->photo;
        if($photo) {
            unlink($photo);
        }
        DB::table('suppliers')->where('id', $id)->delete();

        return response()->json(['status' => 'Success']);
    }
}
