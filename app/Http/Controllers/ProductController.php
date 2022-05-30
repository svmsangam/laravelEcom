<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result['data'] = Product::all();
        return view('admin.product',$result);
    }

    public function manage_product(Request $request, $id=''){
        if($id>0){
            $arr = Product::where(['id'=>$id])->get();
            $result['name'] = $arr['0']->name;
            $result['category_id'] = $arr['0']->category_id;
            $result['image'] = $arr['0']->image;
            $result['desc'] = $arr['0']->desc;
            $result['hasNoEgg'] = $arr['0']->hasNoEgg;
            $result['keywords'] = $arr['0']->keywords;
            $result['status'] = $arr['0']->status;
            $result['slug'] = $arr['0']->slug; 
            $result['id'] = $arr['0']->id;
            $result['prodAttrArr'] = DB::table('product_attrib')->where(['product_id'=>$id])->get();
            // echo'<pre>';
            // print_r($result['prodAttrArr']);
            // die();

        }else{
            $result['name'] ='';
            $result['category_id'] = '';
            $result['image'] = '';
            $result['desc'] ='';
            $result['hasNoEgg'] = 0;
            $result['keywords'] ='';
            $result['status'] ='';
            $result['slug'] = ''; 
            $result['id'] = 0;
            //Product Attribute
            $result['prodAttrArr'][0]['id']='';
            $result['prodAttrArr'][0]['product_id']='';
            $result['prodAttrArr'][0]['sku']='';
            $result['prodAttrArr'][0]['attr_image']='';
            $result['prodAttrArr'][0]['mrp']='';
            $result['prodAttrArr'][0]['price']='';
            $result['prodAttrArr'][0]['quantity']='';
            $result['prodAttrArr'][0]['size_id']='';
            $result['prodAttrArr'][0]['color_id']='';
            $result['prodAttrArr'][0]['flavour_id']='';
            // echo'<pre>';
            // print_r($result['prodAttrArr']);
            // die(); 

        }
        $result['category'] = DB::table('categories')->where(['status'=>1])->get();
        $result['color'] = DB::table('colors')->where(['status'=>1])->get();
        $result['flavour'] = DB::table('flavours')->where(['status'=>1])->get();
        $result['size'] = DB::table('sizes')->where(['status'=>1])->get();
        return view('admin.manage_product',$result);
    }
    public function manage_product_process(Request $request){

        if($request->post('id')>0){
           $image_validation = "mimes:jpeg,jpg,png";
        }else{
            $image_validation = "required|mimes:jpeg,jpg,png";
        }
        $request->validate([
            'name' => 'required',
            'slug'=>'required|unique:products,slug,'.$request->post('id'),
            'desc'=>'required',
            'image'=>$image_validation,

        ]);
        if($request->post('id')>0){
            $product = Product::find($request->post('id'));
            $msg = "Product updated";
        }else{
            $product = new Product();
            $msg = "Product added";
        }


        if($request->hasFile('image')){
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
            $image->storeAs('/public/media',$image_name);
            $product->image = $image_name;            
        }

        $product->name = $request->post('name');
        $product->slug = $request->post('slug');
        $product->category_id = $request->post('category_id');
        $product->desc = $request->post('desc');
        $product->hasNoEgg = $request->has('hasNoEgg');
        $product->keywords = $request->post('keywords');
        $product->save();
        $prod_id=$product->id;
        
        /*Product attribute*/
        $pAttrId = $request->post('prodAId');
        $skuArr = $request->post('sku');
        $mrpArr = $request->post('mrp');
        $priceArr = $request->post('price');
        $qtyArr = $request->post('quantity');
        $size_IdArr = $request->post('size_id');
        $color_IdArr = $request->post('color_id');
        $flavour_IdArr = $request->post('flavour_id');
        $imageAttrArr = $request->post('attr_image');

        foreach($skuArr as $key=>$val){
            $productAttrArr['product_id']=$prod_id;
            $productAttrArr['sku'] = $skuArr[$key];
            $productAttrArr['attr_image']="test";
            $productAttrArr['mrp'] = $mrpArr[$key];
            $productAttrArr['price']=$priceArr[$key];
            $productAttrArr['quantity']=$qtyArr[$key];
            if($size_IdArr[$key]==''){
                $productAttrArr['size_id']=0;    
            }
            else{
                $productAttrArr['size_id']=$size_IdArr[$key];
            }
            if($color_IdArr[$key]==''){
                $productAttrArr['color_id']=0;    
            }
            else{
                $productAttrArr['color_id']=$color_IdArr[$key];
            }
            if($flavour_IdArr[$key]==''){
                $productAttrArr['flavour_id']=0;    
            }
            else{
                $productAttrArr['flavour_id']=$flavour_IdArr[$key];
            }
            if($pAttrId != ''){
                DB::table('product_attrib')->where(['id'=>$pAttrId[$key]])->update($productAttrArr);
            }else{
                DB::table('product_attrib')->insert($productAttrArr);
            }
        }
    
        /*Product attribute*/


        $request->session()->flash('message',$msg);
        return redirect('admin/product');
    }
    public function delete(Request $request, $id){
        $product = Product::find($id);
        $product->delete();
        $request->session()->flash('message','Product Deleted');
        return redirect('admin/product');
    }
    public function product_attr_delete(Request $request,$paId,$pId){
        DB::table('product_attrib')->where(['id'=>$paId])->delete();
        return redirect('admin/product/manage_product/'.$pId);
    }
    public function status(Request $request, $status,$id)
    {
        $product = Product::find($id);
        $product->status = $status;
        $product->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/product');

    }
}
