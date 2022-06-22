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
	if(session()->has('TEMP_USER_ID') === null){
		$rand = rand(111111111,999999999);
		session()->put('TEMP_USER_ID',$rand);
		return $rand;
	}else{
		return session()->has('TEPM_USER_ID');
	}
}
function getCartItems(){
	if(session()->has('USER_LOGIN')){
		$uid = session()->get('USER_LOGIN');
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
?>