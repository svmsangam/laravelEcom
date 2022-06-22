<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
// use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //All categories
        $result['home_categories'] = DB::table('categories')->where(['status'=>1])
                 ->where(['showOnHome'=>1])
                 ->get();
        //getting product  of specific category          
        foreach( $result['home_categories'] as $list){
            $result['home_categories_product'][$list->id] = DB::table('products')
                ->where(['status'=>1])
                ->where(['category_id'=>$list->id])
                ->get();
                //getting product attributes  of specific product
                foreach($result['home_categories_product'][$list->id] as $list1){
                    $result['home_product_attrib'][$list1->id] = DB::table('product_attrib')
                    ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
                    ->leftJoin('colors','colors.id','=','product_attrib.color_id')
                    ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
                    ->where(['product_attrib.product_id'=>$list1->id])->get();
                }      
        }
        //getting featured product
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
        //getting discounted product
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
        //getting trending product
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
        //getting banners
        $result['home_banners'] = DB::table('home_banners')->where(['status'=>1])->get();
        return view('front.index',$result);
    }

    public function product(Request $request,$slug){
        $result['product'] = DB::table('products')
        ->where(['status'=>1])
        ->where(['slug'=>$slug])
        ->get();
    
        foreach($result['product'] as $list1){
            $result['product_attrib'][$list1->id] = DB::table('product_attrib')
            ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
            ->leftJoin('colors','colors.id','=','product_attrib.color_id')
            ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
            ->where(['product_attrib.product_id'=>$list1->id])->get();
        }
        foreach($result['product'] as $list1){
            $result['product_images'][$list1->id] = DB::table('product_images')
            ->where(['product_images.product_id'=>$list1->id])->get();
        }

        $result['related_product'] = DB::table('products')
        ->where(['status'=>1])
        ->where('slug','!=',$slug)
        ->where(['category_id'=>$result['product'][0]->category_id])
        ->get(); 
        foreach($result['related_product'] as $list1){
            $result['related_product_attrib'][$list1->id] = DB::table('product_attrib')
            ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
            ->leftJoin('colors','colors.id','=','product_attrib.color_id')
            ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
            ->where(['product_attrib.product_id'=>$list1->id])->get();
        }     
            // echo"<pre>";
            // print_r($result['product_images']);
            // die(); 
        return view('front.product', $result);
    }

    public function add_to_cart(Request $request){
        if($request->session()->has('USER_LOGIN')){
            $uid = $request->session()->get('USER_LOGIN');
            $user_type = "reg";
        }else{
            $uid = getTempUserId();
            $user_type = "nonReg";
        }
        $size = $request->post('size_id');
        $qty = $request->post('productQty');
        $productId = $request->post('product_id');
        $result = DB::table('product_attrib')
        ->select('product_attrib.id')
        ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
        ->where(['product_id'=>$productId])
        ->where(['sizes.size'=>$size])->get();
        $product_attrib_id = $result[0]->id;
        $check = DB::table('carts')
                ->where(['user_id'=>$uid])
                ->where(['user_type'=>$user_type])
                ->where(['product_id'=>$productId])
                ->where(['product_attr_id'=>$product_attrib_id])
                ->get();

        if(isset($check[0])){
            $update_id = $check[0]->id;
            if($qty == 0 ){
                DB::table('carts')->where(['id'=>$update_id])
                ->delete();
                $msg = "Deleted";
            }else{
                DB::table('carts')->where(['id'=>$update_id])
                ->update(['qty'=>$qty]);
                $msg = "Updated";
            }
        }else{
            $id = DB::table('carts')->insertGetId([
                'user_id'=>$uid,
                'user_type'=>$user_type,
                'product_id'=>$productId,
                'product_attr_id'=>$product_attrib_id,
                'qty'=>$qty,
                'added_on'=>date('Y-m-d h:i:s')
            ]);
            $msg = "Added";
        }        
        // echo "<pre>";
        // print_r($product_attrib_id);
        // die();
        $result = DB::table('carts')
        ->leftJoin('products','products.id','=','carts.product_id')
        ->leftJoin('product_attrib','product_attrib.id','=','carts.product_attr_id')
        ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
        ->leftJoin('colors','colors.id','=','product_attrib.color_id')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->select('carts.qty','products.id as pid','products.name','products.slug','products.image'
                   ,'product_attrib.id as attrId','product_attrib.price','sizes.size','colors.color')
        ->get();
        return response()->json(['msg'=>$msg,'data'=>$result,'totalItemCount'=>count($result)]);
    }

   public function cart(Request $request){
    if($request->session()->has('USER_LOGIN')){
        $uid = $request->session()->get('USER_LOGIN');
        $user_type = "reg";
    }else{
        $uid = getTempUserId();
        $user_type = "nonReg";
    }
    $result['cartList'] = DB::table('carts')
    ->leftJoin('products','products.id','=','carts.product_id')
    ->leftJoin('product_attrib','product_attrib.id','=','carts.product_attr_id')
    ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
    ->leftJoin('colors','colors.id','=','product_attrib.color_id')
    ->where(['user_id'=>$uid])
    ->where(['user_type'=>$user_type])
    ->select('carts.qty','products.id as pid','products.name','products.slug','products.image'
               ,'product_attrib.id as attrId','product_attrib.price','sizes.size','colors.color')
    ->get();
    return view('front.cart',$result);
   }
   public function category(Request $request, $slug){
            $result['category_product'] = DB::table('products')
            ->leftJoin('categories','categories.id','=','products.category_id')
            ->select('products.id as pid','products.name','products.image','products.desc','products.slug')
            ->where(['products.status'=>1])
            ->where(['categories.slug'=>$slug])
            ->get();

        foreach($result['category_product'] as $list1){
            $result['product_attrib'][$list1->pid] = DB::table('product_attrib')
            ->leftJoin('sizes','sizes.id','=','product_attrib.size_id')
            ->leftJoin('colors','colors.id','=','product_attrib.color_id')
            ->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id')
            ->where(['product_attrib.product_id'=>$list1->pid])->get();
        }  
        // prx($result);   
    return view('front.category',$result);
   }
}
