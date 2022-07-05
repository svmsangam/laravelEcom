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
}
