<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $customers = Customer::all();
        $customers = DB::table('customers')->orderBy('id', 'DESC')->get();
        return response()->json($customers);
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
        'name' => 'required|unique:customers|max:150',
        'email' => 'required|unique:customers|max:150',
        'phone' => 'required|unique:customers|max:150',
        'address' => 'required'
        ]);

        if ($request->photo) {
        $position = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $position);
        $ext = explode('/', $sub)[1];

        $name = time() . "." . $ext;
        $image = Image::make($request->photo)->resize(240,200);
        // Be Sure to Create customers folder else getting undefined Name Error
        $upload_path = 'backend/customers/';
        $image_url = $upload_path.$name;

        $image->save($image_url);

        } else {
        $image_url = '';
        }
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->photo = $image_url;
        $customer->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        return response()->json($customer);
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
        'phone' => 'required|max:150',
        'address' => 'required'
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        // $data['photo'] = $request->new_photo;
        $image = $request->new_photo;
        if($image) {
        $position = strpos($image, ';');
        $sub = substr($image, 0, $position);
        $ext = explode('/', $sub)[1];

        $name = time() . "." . $ext;
        $image = Image::make($image)->resize(240,200);
        $upload_path = 'backend/customers/';
        $image_url = $upload_path.$name;

        $result = $image->save($image_url);
        if($result) {
        $data['photo'] = $image_url;
        $img = DB::table('customers')->where('id', $id)->first();
        $image_path = $img->photo;
        $res = unlink($image_path);
        }
        } else {
        $data['photo'] = $request->photo;
        }
        DB::table('customers')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        $photo = $customer->photo;
        if($photo) {
        unlink($photo);
        }
        DB::table('customers')->where('id', $id)->delete();

        return response()->json(['status' => 'Success']);
    }
}
