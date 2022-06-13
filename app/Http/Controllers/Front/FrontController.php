<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
// use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result['home_categories'] = DB::table('categories')->where(['status'=>1])
                 ->where(['showOnHome'=>1])
                 ->get();
        foreach( $result['home_categories'] as $list){
            $result['home_categories_product'][$list->id] = DB::table('products')
                ->where(['status'=>1])
                ->where(['category_id'=>$list->id])
                ->get();
                
                foreach($result['home_categories_product'][$list->id] as $list1){
                    $result['home_product_attrib'][$list1->id] = DB::table('product_attrib')
                    ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
                    ->leftJoin('colors','colors.id','=','product_attrib.color_id')
                    ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
                    ->where(['product_attrib.product_id'=>$list1->id])->get();
                }      
        }
        $result['home_featured_product'][$list->id] = DB::table('products')
            ->where(['status'=>1])
            ->where(['is_featured'=>1])
            ->get();
        
        foreach($result['home_featured_product'][$list->id] as $list1){
            $result['home_featured_product_attrib'][$list1->id] = DB::table('product_attrib')
            ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
            ->leftJoin('colors','colors.id','=','product_attrib.color_id')
            ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
            ->where(['product_attrib.product_id'=>$list1->id])->get();
        }
        $result['home_discounted_product'][$list->id] = DB::table('products')
            ->where(['status'=>1])
            ->where(['is_discounted'=>1])
            ->get();
        
        foreach($result['home_discounted_product'][$list->id] as $list1){
            $result['home_discounted_product_attrib'][$list1->id] = DB::table('product_attrib')
            ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
            ->leftJoin('colors','colors.id','=','product_attrib.color_id')
            ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
            ->where(['product_attrib.product_id'=>$list1->id])->get();
        }
        $result['home_trending_product'][$list->id] = DB::table('products')
            ->where(['status'=>1])
            ->where(['is_trending'=>1])
            ->get();
        
        foreach($result['home_trending_product'][$list->id] as $list1){
            $result['home_trending_product_attrib'][$list1->id] = DB::table('product_attrib')
            ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
            ->leftJoin('colors','colors.id','=','product_attrib.color_id')
            ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
            ->where(['product_attrib.product_id'=>$list1->id])->get();
        }       
        // echo"<pre>";
        // print_r($result);
        // die();

        return view('front.index',$result);
    }





   
}
