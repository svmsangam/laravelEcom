<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data'] = Coupon::all();
        return view('admin.coupon',$result);
    }

    public function manage_coupon(Request $request, $id=''){
        if($id>0){
            $arr = Coupon::where(['id'=>$id])->get();
            $result['title'] = $arr['0']->title;
            $result['value'] = $arr['0']->value;
            $result['code'] = $arr['0']->code; 
            $result['id'] = $arr['0']->id;

        }else{
            $result['title'] = '';
            $result['value'] = '';
            $result['code'] = '';
            $result['id'] = 0;
        }
        return view('admin.manage_coupon',$result);
    }
    public function manage_coupon_process(Request $request){
        $request->validate([
            'title' => 'required',
            'code'=>'required|unique:coupons,code,'.$request->post('id'),
            'value'=>'required'
        ]);
        if($request->post('id')>0){
            $coupon = Coupon::find($request->post('id'));
            $msg = "Coupon Updated";
        }else{
            $coupon = new Coupon();
            $msg = "Coupon Added";
        }
       $coupon->title = $request->post('title');
       $coupon->code = $request->post('code');
       $coupon->value = $request->post('value');
       $coupon->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/coupon');
    }
    public function delete(Request $request, $id){
       $coupon = Coupon::find($id);
       $coupon->delete();
        $request->session()->flash('message','Coupon Deleted');
        return redirect('admin/coupon');
    }
    public function status(Request $request, $status,$id)
    {
        $coupon = Coupon::find($id);
        $coupon->status = $status;
        $coupon->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/coupon');

    }
}