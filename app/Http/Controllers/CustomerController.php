<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request){

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|min:8|max:10|unique:customers,phone',
            'pincode' => 'required|min:6',
            'address' => 'required',
        ];
     
    
        $this->validate($request, $rules);
        
       $data= Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
        ]);
        CustomerAddress::create([
            'address'=>$request->address,
            'pincode'=>$request->pincode,
            'customer_id'=>$data->id,
        ]);

        return back()->with('success','Customer added successfully');
    }

    public function dublicateCheck(Request $request){
        if($request->email){
            $data=null;
            $dataCheck=  Customer::where('email','LIKE', "$request->email")->get()->first();
            if($dataCheck){
                $data="dublicate";
            }else{
                $data="not";
            }
        }else{
            $data=null;
            $dataCheck=  Customer::where('phone','LIKE', "$request->phone")->get()->first();
            if($dataCheck){
                $data="dublicate";
            }else{
                $data="not";
            }
        }
     

        return response()->json($data);
    }
}
