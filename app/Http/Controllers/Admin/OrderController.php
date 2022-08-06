<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $result['orders']=DB::table('orders')
        ->select('orders.*','order_status.status')
        ->leftJoin('order_status','order_status.id','=','orders.order_status')
        ->get();   
        return view('admin.order',$result);
    }    

    public function order_detail(Request $request,$id)
    {
        $result['orders_details']=
                DB::table('order_details')
                ->select('orders.*','order_details.price','order_details.qty','products.name as pname','product_attrib.attr_image','sizes.size','colors.color','order_status.status')
                ->leftJoin('orders','orders.id','=','order_details.order_id')
                ->leftJoin('product_attrib','product_attrib.id','=','order_details.product_attr_id')
                ->leftJoin('products','products.id','=','product_attrib.product_id')
                ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
                ->leftJoin('order_status','order_status.id','=','orders.order_status')
                ->leftJoin('colors','colors.id','=','product_attrib.color_id')
                ->where(['orders.id'=>$id])
                ->get();
                // prx($result);

        $result['order_status']=
            DB::table('order_status')
            ->get();
        $result['payment_status']=['Pending','Success','Fail'];      
        return view('admin.order_detail',$result);
    } 

    public function update_payemnt_status(Request $request,$status,$id)
    {
        DB::table('orders')
        ->where(['id'=>$id])
        ->update(['payment_status'=>$status]);
        return redirect('/admin/order_detail/'.$id);
    } 

    public function update_order_status(Request $request,$status,$id)
    {
        DB::table('orders')
        ->where(['id'=>$id])
        ->update(['order_status'=>$status]);
        return redirect('/admin/order_detail/'.$id);
    } 

    
    
}
