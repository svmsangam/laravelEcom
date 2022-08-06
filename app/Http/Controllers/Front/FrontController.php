<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
// use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
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
        
        $result['product_review']=
        DB::table('product_review')
        ->leftJoin('customers','customers.id','=','product_review.customer_id')
        ->where(['product_review.product_id'=>$result['product'][0]->id])
        ->where(['product_review.status'=>1])
        ->orderBy('product_review.added_on','desc')
        ->select('product_review.rating','product_review.review','product_review.added_on','customers.name')
        ->get();
            // echo"<pre>";
            // print_r($result['product_images']);
            // die(); 
        return view('front.product', $result);
    }

    public function add_to_cart(Request $request){
        $SKU = '';
        $finalAvailable = 0;
        if($request->session()->has('USER_LOGIN')){
            $uid = $request->session()->get('USER_ID');
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

        $getAvailableStockQty = getAvaliableQty($productId,$product_attrib_id); 

        $finalAvailable=$getAvailableStockQty[0]->pqty - $getAvailableStockQty[0]->qty;
        if($qty>$finalAvailable){
            return response()->json(['msg'=>"not_avaliable",'data'=>"Only $finalAvailable left"]);
        }

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
                    $SKU=  DB::table('product_attrib')
                    ->where(['product_attrib.product_id'=>$productId])
                    ->where(['product_attrib.id' =>$product_attrib_id])
                    ->select('product_attrib.sku','product_attrib.quantity')
                    ->get();
                    $remainingStock = $SKU[0]->quantity - $qty;
                    DB::table('product_attrib')
                    ->where(['sku'=>$SKU[0]->sku])
                    ->update([
                        'product_attrib.quantity'=>$remainingStock
                    ]);

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
            if($id>0){
                $SKU=  DB::table('product_attrib')
                 ->where(['product_attrib.product_id'=>$productId])
                 ->where(['product_attrib.id' =>$product_attrib_id])
                 ->select('product_attrib.sku','product_attrib.quantity')
                 ->get();
                $remainingStock = $SKU[0]->quantity - $qty;
                DB::table('product_attrib')
                ->where(['sku'=>$SKU[0]->sku])
                ->update([
                    'product_attrib.quantity'=>$remainingStock
                ]);
            }
            $msg = "Added";
        }         

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
        $uid = $request->session()->get('USER_ID');
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
        $result['slug'] = $slug;
        $sort = "";
        $sort_txt = "";
        $filter_price_min = 100;
        $filter_price_max = 1000;
        if($request->get('sort')!==null){
            $sort = $request->get('sort');
        }
        
            $query = DB::table('products');
            $query = $query->leftJoin('categories','categories.id','=','products.category_id');
            $query = $query->leftJoin('product_attrib','product_attrib.product_id','=','products.id');
            $query=$query->where(['products.status'=>1]);
            $query=$query->where(['categories.slug'=>$slug]);

            if($sort == 'name'){
                $query = $query->orderBy('products.name','asc');
                $sort_txt = "Product Name";
            }
            if($sort == 'date'){
                $query = $query->orderBy('products.id','asc');
                $sort_txt = "Date";
            }
            if($sort == 'price_lth'){
                $query = $query->orderBy('product_attrib.price','asc');
                $sort_txt = "Price low to high";
            }
            if($sort == 'price_htl'){
                    $query = $query->orderBy('product_attrib.price','desc');
                    $sort_txt = "Price high to low";
            }
            if($request->get('filter_price_min')!=null  && $request->get('filter_price_min')!=null){
                $filter_price_min = $request->get('filter_price_min');
                $filter_price_max = $request->get('filter_price_max');
                if( $filter_price_min>0 &&  $filter_price_max>0){
                    $query = $query->whereBetween('product_attrib.price',[$filter_price_min,$filter_price_max]);
                }
            }
            $query=$query->distinct()->select('products.*'); 
            $query = $query->get();
            
            $result['category_product'] = $query;


        foreach($result['category_product'] as $list1){

          $query = DB::table('product_attrib');
          $query =$query->leftJoin('sizes','sizes.id','=','product_attrib.size_id');
          $query =$query->leftJoin('colors','colors.id','=','product_attrib.color_id');
          $query = $query->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id');
          $query =  $query->where(['product_attrib.product_id'=>$list1->id]); 
            $query =$query ->get();
            $result['product_attrib'][$list1->id] = $query;
        }          
        $result['sort'] = $sort;
        $result['sort_txt'] = $sort_txt;
        $result['filter_price_min'] = $filter_price_min;
        $result['filter_price_max'] = $filter_price_max;


        $result['categories_left'] = DB::table('categories')->where(['status'=>1])
        ->where(['showOnHome'=>1])
        ->get();
        // prx($result); 
    return view('front.category',$result);
   }
   public function search(Request $request, $str){
        $result['search_product'] =  $query = DB::table('products');
        $query = $query->leftJoin('categories','categories.id','=','products.category_id');
        $query = $query->leftJoin('product_attrib','product_attrib.product_id','=','products.id');
        $query=$query->where(['products.status'=>1]);
        $query=$query->where('products.keywords','like',"%$str%");
        $query=$query->orwhere('products.name','like',"%$str%");
        $query=$query->orwhere('products.desc','like',"%$str%");
        $query=$query->distinct()->select('products.*'); 
        $query = $query->get();
        
        $result['search_product'] = $query;


            foreach($result['search_product'] as $list1){

            $query = DB::table('product_attrib');
            $query =$query->leftJoin('sizes','sizes.id','=','product_attrib.size_id');
            $query =$query->leftJoin('colors','colors.id','=','product_attrib.color_id');
            $query = $query->leftJoin('flavours','flavours.id','=','product_attrib.flavour_id');
            $query =  $query->where(['product_attrib.product_id'=>$list1->id]); 
                $query =$query ->get();
                $result['product_attrib'][$list1->id] = $query;
            }
        // prx($result); 
        return view('front.search',$result);         
   }
   public function register(Request $request){
        if($request->session()->has('USER_LOGIN')!=null){
            return redirect('/');
        }else{
        return view('front.register');
        }
   }
   public function userRegister(Request $request){
       $valid = Validator::make($request->all(),[
            "name"=>'required',
            "email"=>'required|email|unique:customers,email',
            "mobile"=>'required|numeric|digits:10',
            "password"=>'required|confirmed|min:6'            
       ]); 
       if($valid->fails()){
            return response()->json(['status'=>'error','error'=>$valid->errors()->toArray()]);
       }else{
            $rand_id = rand(111111111,999999999);
            $arr = [
                "name"=>$request->name,
                "email"=>$request->email,
                "mobile"=>$request->mobile,
                "password"=>Crypt::encrypt($request->password),
                "is_verified"=>0,
                "rand_id"=>$rand_id,
                "created_at"=>date('Y-m-d h:i:s'),
                "updated_at"=>date('Y-m-d h:i:s'),
            ];
            $query = DB::table('customers')->insert($arr);
            if($query){
                $data = ['name'=>$request->name,'rand_id'=>$rand_id];
                $user['to'] = $request->email;
                Mail::send('front/email_verification',$data,function($messages) use ($user){
                    $messages->to($user['to']);
                    $messages->subject('Verify your email');
                });
                return response()->json(['status'=>'success','msg'=>'User Registration Successful. Please verify your email. 
                Verification link might be in spam folder']);
            }        
       }
   }
   public function userLogin(Request $request){
        $result = DB::table('customers')
        ->where(['email'=>$request->loginEmail])
        ->get();
        if(isset($result[0])){
            $db_pwd = Crypt::decrypt($result[0]->password);
            $status = $result[0]->status;
            $is_verified = $result[0]->is_verified;

            if($is_verified == 0){
                return response()->json(['status'=>'error','msg'=>'Please verify your email']);
            }
            if($status == 0){
                return response()->json(['status'=>'error','msg'=>'Your account has been deactivated']);
            }
            if($db_pwd==$request->loginPassword){
                if($request->rememberme === null){
                    setcookie('login_email',$request->loginEmail,100);
                    setcookie('login_pwd',$request->loginPassword,100);
                }else{
                    setcookie('login_email',$request->loginEmail,time()+60*60*24*30);
                    setcookie('login_pwd',$request->loginPassword,time()+60*60*24*30);
                }
                $request->session()->put('USER_LOGIN',true);
                $request->session()->put('USER_ID',$result[0]->id);
                $request->session()->put('USER_NAME',$result[0]->name);
                $status = 'success';
                $msg = '';
                $getUserTempId = getTempUserId();
                DB::table('carts')
                ->where(['user_id'=>$getUserTempId])
                ->where(['user_type'=>'nonReg'])
                ->update(
                    [
                        'user_id'=>$result[0]->id,
                        'user_type'=>'reg'
                    ]
                );  
            }else{
                $status = 'error';
                $msg = 'Invalid Credentials';
            }
        }else{
            $status = 'error';
            $msg = 'Incorrect Email';
        }
        return response()->json(['status'=>$status,'msg'=>$msg]); 
    }

    public function verify_email(Request $request, $rand_id){
        $result = DB::table('customers')
        ->where(['rand_id'=>$rand_id])
        ->where(['is_verified'=>0])
        ->get();
        if(isset($result[0])){
            DB::table('customers')
            ->where(['id'=>$result[0]->id])
            ->update(['is_verified'=>1,'rand_id'=>'']);
            return view('front.verified');
        }else{
            return redirect('/');
        }
    }
    public function forgotPassword(Request $request){
        $rand_id = rand(111111111,999999999);
        $result = DB::table('customers')
                    ->where(['email'=>$request->forgotPasswordEmail])
                    ->where(['is_forgot_password'=>0])
                    ->get();
        if(isset($result[0])){
            DB::table('customers')
            ->where(['email'=>$request->forgotPasswordEmail])
            ->update(['is_forgot_password'=>1,'rand_id'=>$rand_id]);
            $data = ['name'=>$result[0]->name,'rand_id'=>$rand_id];
            $user['to'] = $request->forgotPasswordEmail;
            Mail::send('front/verify_password_recovery',$data,function($messages) use ($user){
                $messages->to($user['to']);
                $messages->subject('Reset Password');
            });
            return response()->json(['status'=>'success','msg'=>'Password reset link has been sent to your email.']); 
        }else{
            return response()->json(['status'=>'error','msg'=>'Email id does not exists']);   
        }            
    }
    public function password_reset(Request $request, $rand_id){
        $result = DB::table('customers')
        ->where(['rand_id'=>$rand_id])
        ->where(['is_forgot_password'=>1])
        ->get();
        if(isset($result[0])){ 
            $request->session()->put('FORGOT_PASSWORD_UID',$result[0]->id);
            return view('front.password_reset');
        }else{
            return redirect('/');
        }                
    }
    public function password_reset_process(Request $request){
       DB::table('customers')
        ->where(['id'=>session()->get('FORGOT_PASSWORD_UID')])
        ->update(
            [
                'is_forgot_password'=>0,
                'password'=>Crypt::encrypt($request->passwordReset),
                'rand_id'=>''
            ]
        );
        return response()->json(['status'=>'success','msg'=>'Password changed.']);              
    }
    public function checkout(Request $request){
        $result['cart_data'] = getCartItems();
        if(isset($result['cart_data'][0])){ 
            if($request->session()->has('USER_LOGIN')){
                $uid = $request->session()->get('USER_ID');
                $customer = DB::table('customers')
                ->where(['id'=>$uid])
                ->get();
                $result['customers']['name'] = $customer[0]->name;
                $result['customers']['email'] = $customer[0]->email;
                $result['customers']['mobile'] = $customer[0]->mobile;
                $result['customers']['address'] = $customer[0]->address;
                $result['customers']['city'] = $customer[0]->city;

            }else{
                $result['customers']['name'] ='';
                $result['customers']['email'] = '';
                $result['customers']['mobile'] = '';
                $result['customers']['address'] = '';
                $result['customers']['city'] ='';
            }
            return view('front.checkout',$result);
        }else{
           return redirect('/');
        }        
    }
    public function apply_coupon_code(Request $request){
        $arr = apply_coupon_code($request->coupon_code);
        $arr = json_decode($arr,true);
        
        return response()->json(['status'=>$arr['status'],'msg'=>$arr['msg'],'totalPrice'=>$arr['totalPrice']]);

 
    }
    public function remove_coupon_code(Request $request){
        $totalPrice = 0;
        // $result = DB::table('coupons')
        // ->where(['code'=>$request->coupon_code])
        // ->get();
        $getCartItems = getCartItems();
        foreach($getCartItems as $list){
            $totalPrice = $totalPrice+($list->qty*$list->price);
        }        
     
        return response()->json(['status'=>'success','msg'=>'Coupon Removed','totalPrice'=>$totalPrice]); 
    }
    public function place_order(Request $request){
        $totalPrice = 0;
        $coupon_value = 0;
        $productDetailArr = [];
        if($request->session()->has('USER_LOGIN')){
            $uid = $request->session()->get('USER_ID');

            if($request->coupon_code !== null){
                $arr = apply_coupon_code($request->coupon_code);
                $arr = json_decode($arr,true);
                if($arr['status'] == 'success'){
                        $coupon_value = $arr['coupon_code_value'];
                }else{
                    return response()->json(['status'=>'error','msg'=>$arr['msg']]);            
                }
            }
            $getCartItems = getCartItems();
            foreach($getCartItems as $list){
                $totalPrice = $totalPrice+($list->qty*$list->price)-$coupon_value;
            }
            if($request->payment_type=="COD"){
            $arr = [
                "customer_id"=>$uid,
                "name"=>$request->name,
                "email"=>$request->email,
                "mobile"=>$request->mobile,
                "address"=>$request->address,
                "city"=>$request->city,
                "coupon_code"=>$request->coupon_code,
                "coupon_value"=>$coupon_value,
                "order_status"=>1,
                "payment_type"=>$request->payment_type,
                "payment_status"=>"Pending",
                "payment_id"=>0,
                "total_amt"=>$totalPrice,
                "added_on"=>date('Y-m-d h:i:s'),
            ];
            $order_id = DB::table('orders')->insertGetId($arr);
            if($order_id>0){
            $i = 0;  
            foreach($getCartItems as $list1){
                $productDetailArr[$i]['order_id'] = $order_id;
                $productDetailArr[$i]['product_id'] = $list1->pid;
                $productDetailArr[$i]['product_attr_id'] = $list1->attrId;
                $productDetailArr[$i]['price'] = $list1->price;
                $productDetailArr[$i]['qty'] = $list1->qty;               
                $i++;

            }
            DB::table('order_details')->insert($productDetailArr); 
            
            DB::table('carts')->where(['user_id'=>$uid,'user_type'=>'reg'])->delete();
            $request->session()->put('ORDER_ID',$order_id);
            $status = "success";
            $msg = "Order Placed";
            }
            return response()->json(['status'=>$status,'msg'=>$msg]);    
        }if($request->payment_type == 'Gateway'){
            $arr = [
                "customer_id"=>$uid,
                "name"=>$request->name,
                "email"=>$request->email,
                "mobile"=>$request->mobile,
                "address"=>$request->address,
                "city"=>$request->city,
                "coupon_code"=>$request->coupon_code,
                "coupon_value"=>$coupon_value,
                "order_status"=>2,
                "payment_type"=>$request->payment_type,
                "payment_status"=>"Pending",
                "payment_id"=>0,
                "total_amt"=>$totalPrice,
                "added_on"=>date('Y-m-d h:i:s'),
            ];
            return response()->json(['status'=>'khalti','msg'=>'Gateway payment','totalAmt'=>$totalPrice,
            'order_details'=>$arr]);         
        }
        else{
            $status = "error";
            $msg = "Failed to place order";
        }
            // prx($productDetailArr);         
        }else{
            return response()->json(['status'=>'error','msg'=>'Please login first!!!']);;  
            // return redirect('')
        }
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }
    public function order_placed(Request $request){
        if($request->session()->has('ORDER_ID')){
            return view('front.order_placed');
            session()->forget('ORDER_ID');
        }else{
            return redirect('/');
        }
    }
    public function payment_verification(Request $request){
        $token = $request->token;
        $amt = 0;
        $orderInfo = array_values($request->order_info);
        // prx($orderInfo[12]);
        $amt = $orderInfo[12]*100;
        $args = http_build_query(array(
            'token' => $token,
            'amount'  => $amt
        ));
        
        $url = "https://khalti.com/api/v2/payment/verify/";
        
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = ['Authorization: Key test_secret_key_f541316303304235ad569ba174ce0baf'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($status_code == 200){
            return response()->json(['status'=>'success' ,'msg'=>'Payment successful']);
        }else{
            return response()->json(['status'=>'error','msg'=>'Payment failed. Try again']);
        }
        
    }
    public function store_order_gateway_payment(Request $request){
        $getCartItems = getCartItems();
        $uid = $request->session()->get('USER_ID');
        $orderInfo = $request->order_info;
        $arr = [
            "customer_id"=>$uid,
            "name"=>$orderInfo['name'],
            "email"=>$orderInfo['email'],
            "mobile"=>$orderInfo['mobile'],
            "address"=>$orderInfo['address'],
            "city"=>$orderInfo['city'],
            "coupon_code"=>$orderInfo['coupon_code'],
            "coupon_value"=>$orderInfo['coupon_value'],
            "order_status"=>1,
            "payment_type"=>strtolower($orderInfo['payment_type']),
            "payment_status"=>"Success",
            "payment_id"=>$request->payment_id,
            "total_amt"=>$orderInfo['total_amt'],
            "added_on"=>$orderInfo['added_on'],
        ];
       
        $order_id = DB::table('orders')->insertGetId($arr);
        if($order_id>0){
        $i = 0;  
        foreach($getCartItems as $list1){
            $productDetailArr[$i]['order_id'] = $order_id;
            $productDetailArr[$i]['product_id'] = $list1->pid;
            $productDetailArr[$i]['product_attr_id'] = $list1->attrId;
            $productDetailArr[$i]['price'] = $list1->price;
            $productDetailArr[$i]['qty'] = $list1->qty;               
            $i++;

        }
        DB::table('order_details')->insert($productDetailArr); 
        
        DB::table('carts')->where(['user_id'=>$uid,'user_type'=>'reg'])->delete();
        $request->session()->put('ORDER_ID',$order_id);
        $status = "success";
        $msg = "Order Placed";
        return response()->json(['status'=>$status,'msg'=>$msg]);
        }
    }
    public function getOrder(Request $request){
        $result['orders'] = DB::table('orders')
                            ->select('orders.*','order_status.status')
                            ->leftJoin('order_status','order_status.id' ,'=','orders.order_status')
                            ->where(['customer_id'=>$request->session()->get('USER_ID')])
                            ->get();
        // prx($result);
        return view('front.order',$result);
    }
    public function getOrderDetails(Request $request, $id){
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
        ->where(['orders.customer_id'=>$request->session()->get('USER_ID')])
        ->get();
        // prx($result);
        if(!isset($result['orders_details'][0])){
            return redirect('/');
        }
        return view('front.order_detail',$result);
    }
    public function product_review_process(Request $request){
        if($request->session()->has('USER_LOGIN')){
            $uid = $request->session()->get('USER_ID');
            // prx($_POST);
            $arr=[
                "rating"=>$request->rating,
                "review"=>$request->review,
                "product_id"=>$request->product_id,
                "status"=>1,
                "customer_id"=>$uid,
                "added_on"=>date('Y-m-d h:i:s')
            ];
            $query=DB::table('product_review')->insert($arr);

            $status = "success";
            $msg = "Thank you for the review!!!";
        }else{
            $status = "error";
            $msg = "Order Placed";
            $request->session()->flash('error','Please login first.');
        }
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }
}
