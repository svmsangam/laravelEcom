<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result['data'] = Customer::all();
        return view('admin.customer',$result);
    }

    public function view_customer($id){
        $customerArr = Customer::where(['id'=>$id])->get();  
        $result['customer_details'] = $customerArr[0];   
        return view('admin.view_customer',$result);
    }
    public function status(Request $request, $status,$id)
    {
        $customer = Customer::find($id);
        $customer->status = $status;
        $customer->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/customer');

    }
    // public function updatePassword(){
    //     $r = Customer::find(1);
    //     $r ->password = Hash::make($r->password);
    //     $r->save();
    // }
}
