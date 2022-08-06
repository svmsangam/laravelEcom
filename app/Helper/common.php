<?php

use Illuminate\Support\Facades\DB;

$html='';
function prx($arr){
    echo "<pre>";
    print_r($arr);
    die();
}
function getTopNav(){
    $result= DB::table('categories')->where(['status'=>1])->get();
    $arr=[];
    foreach($result as $row){
        $arr[$row->id]['name']=$row->category_name;
        $arr[$row->id]['parent_id']=$row->parent_category_id;
		$arr[$row->id]['slug']=$row->slug;
    }
    $str = buildTreeView($arr,0);
    return $str;
}
function buildTreeView($arr,$parent,$level=0,$prelevel= -1){
	global $html;
	foreach($arr as $id=>$data){
		if($parent==$data['parent_id']){
			if($level>$prelevel){
				if($html==''){
					$html.='<ul class="nav navbar-nav">';
				}else{
					$html.='<ul class="dropdown-menu">';
				}
				
			}
			if($level==$prelevel){
				$html.='</li>';
			}
			$html.='<li><a href="/category/'.$data['slug'].'">'.$data['name'].'<span class="caret"></span></a>';
			if($level>$prelevel){
				$prelevel=$level;
			}
			$level++;
			buildTreeView($arr,$id,$level,$prelevel);
			$level--;
		}
	}
	if($level==$prelevel){
		$html.='</li></ul>';
	}
	return $html;
}
function getTempUserId(){
	if(!session()->has('USER_TEMP_ID')){
		$rand = rand(111111111,999999999);
		session()->put('USER_TEMP_ID',$rand);
		return $rand;
	}else{
		return session()->get('USER_TEMP_ID');
	}
}
function getCartItems(){
	if(session()->has('USER_LOGIN')){
		$uid = session()->get('USER_ID');
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
	return $result['cartList'];
}
function apply_coupon_code($coupon_code){
	$totalPrice = 0;
        $result = DB::table('coupons')
        ->where(['code'=>$coupon_code])
        ->get();
        if(isset($result[0])){
            $value = $result[0]->value;
            $type = $result[0]->type;
            if($result[0]->status==1){
                if($result[0]->is_one_time==1){
                    $status = 'error';
                    $msg = 'Coupon already used';
                }else{
                    $min_order_amt = $result[0]->min_order_amt;
                    if($min_order_amt>0){
                        $getCartItems = getCartItems();
                        foreach($getCartItems as $list){
                            $totalPrice = $totalPrice+($list->qty*$list->price);
                        }
                        if($min_order_amt<$totalPrice){
                            $status = 'success';
                            $msg = 'Coupon Applied'; 
                        }else{
                            $status = 'error';
                            $msg = 'Mininum order amount for this coupon is '.$min_order_amt; 
                        }
                    }else{
                        $getCartItems = getCartItems();
                        foreach($getCartItems as $list){
                            $totalPrice = $totalPrice+($list->qty*$list->price);
                        }
                        $status = 'success';
                        $msg = 'Coupon Applied'; 
                    }
                }
        }else{
            $status = 'error';
            $msg = 'Coupon Expired';
        }
           // $status = 'success';
            // $msg = ' Valid Coupon';            
        }else{
            $status = 'error';
            $msg = 'Invalid Coupon';
        }
		$coupon_code_value = 0;
        if($status == 'success'){
            if($type=='val'){
                $totalPrice = $totalPrice-$value;
				$coupon_code_value = $value;
            }
            if($type=='per'){
                $perValue = ($value/100)*$totalPrice;
                $totalPrice = $totalPrice-$perValue;
				$coupon_code_value = $perValue;
            }
        }
        return json_encode(['status'=>$status,'msg'=>$msg,'totalPrice'=>$totalPrice,'coupon_code_value'=>$coupon_code_value]); 
}
function getCustomDate($date){
	if($date!=''){
		$date=strtotime($date);
		return date('d-M Y',$date);
	}
}
function getAvaliableQty($product_id,$attr_id){
	$result=DB::table('order_details')
            ->leftJoin('orders','orders.id','=','order_details.order_id')
			->leftJoin('product_attrib','product_attrib.id','=','order_details.product_attr_id')
            ->where(['order_details.product_id'=>$product_id])
            ->where(['order_details.product_attr_id'=>$attr_id])
            ->select('order_details.qty','product_attrib.quantity as pqty')
            ->get();

	return $result;
}
?>