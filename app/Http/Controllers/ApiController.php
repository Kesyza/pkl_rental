<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class ApiController extends Controller
{
    //menampilkan data customer
    public function index(){
        $customer = Customer::all();

        //ubah ke JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Customer',
            'data'    => $customer  
        ], 200);
    }

    public function create(){
        //
    }

    public function store(Request $request){
        //menambah data sopir pada JSON
        DB::beginTransaction();
        try {
            $requset = $request->merge(['slug'=>$request->name]);
            $this->customer->create($request->all());
            DB::commit();
            return redirect()->route('customer.index')->with('success-message','Data telah disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error-message',$e->getMessage());
        }
    }
}
