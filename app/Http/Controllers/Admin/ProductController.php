<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $result['lead_time'] = $arr['0']->lead_time;
            $result['tax'] = $arr['0']->tax;
            $result['tax_type'] = $arr['0']->tax_type;
            $result['is_promo'] = $arr['0']->is_promo;
            $result['is_featured'] = $arr['0']->is_featured;
            $result['is_discounted'] = $arr['0']->is_discounted;
            $result['is_trending'] = $arr['0']->is_trending;
            $result['prodAttrArr'] = DB::table('product_attrib')->where(['product_id'=>$id])->get();
            $prodImageArr= DB::table('product_images')->where(['product_id'=>$id])->get();
            // echo'<pre>';
            // print_r($result['prodAttrArr']);
            // die();
            if(!isset($prodImageArr[0])){
                $result['prodImageArr'][0]['id']='';
                $result['prodImageArr'][0]['images']='';
                $result['prodImageArr'][0]['product_id']='';
            }else{
                $result['prodImageArr'] = $prodImageArr;
            }

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
            $result['lead_time'] = '';
            $result['tax']='';
            $result['tax_type'] = '';
            $result['is_promo'] = '';
            $result['is_featured'] = '';
            $result['is_discounted'] = '';
            $result['is_trending'] = '';
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
            //Product Images
            $result['prodImageArr'][0]['product_id']='';
            $result['prodImageArr'][0]['id']='';
            $result['prodImageArr'][0]['images']='';

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
            'attr_image.*'=>'mimes:jpeg,jpg,png',
            'images.*'=>'mimes:jpeg,jpg,png',
            'quantity.*'=>'required|integer',
            'mrp.*'=>'required|numeric',
            'price.*'=>'required|numeric'

        ]);
        if($request->post('id')>0){
            $product = Product::find($request->post('id'));
            $msg = "Product updated";
        }else{
            $product = new Product();
            $msg = "Product added";
        }


        if($request->hasFile('image')){
            if($request->post('id')>0){
                $arrImages = DB::table('products')->where(['id'=>$request->post('id')])->get();
                if(Storage::exists('/public/media/'.$arrImages[0]->image)){
                    Storage::delete('/public/media/'.$arrImages[0]->image);
                }
            }
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
        $product->lead_time = $request->post('lead_time');
        $product->tax = $request->post('tax');
        $product->tax_type = $request->post('tax_type');
        $product->is_promo = $request->post('is_promo');
        $product->is_featured = $request->post('is_featured');
        $product->is_discounted = $request->post('is_discounted');
        $product->is_trending = $request->post('is_trending');
        $product->save();
        $prod_id=$product->id;

        /*Product attribute*/
        $paidArr = $request->post('paid');
        $skuArr = $request->post('sku');
        $mrpArr = $request->post('mrp');
        $priceArr = $request->post('price');
        $qtyArr = $request->post('quantity');
        $size_IdArr = $request->post('size_id');
        $color_IdArr = $request->post('color_id');
        $flavour_IdArr = $request->post('flavour_id');


        foreach($skuArr as $key=>$val){
            $productAttrArr = [];
            $check = DB::table('product_attrib')->where('sku' ,'=' , $skuArr[$key])
                ->where('id' ,'!=' , $paidArr[$key])->get();

            if(isset($check[0])){
                $request->session()->flash('sku_error','SKU:'.$skuArr[$key].' already used.');
                return redirect(request()->headers->get('referer'));
            }else{
                $productAttrArr['product_id']=$prod_id;
                $productAttrArr['sku'] = $skuArr[$key];
                $productAttrArr['mrp'] =(int) $mrpArr[$key];
                $productAttrArr['price']=(int)$priceArr[$key];
                $productAttrArr['quantity']=(int)$qtyArr[$key];
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
                if($request->hasFile("attr_image.$key")){
                    if($paidArr[$key]!=''){
                        $arrAttrImages = DB::table('product_attrib')->where(['id'=>$paidArr[$key]])->get();
                            if(Storage::exists('/public/media/'.$arrAttrImages[0]->attr_image)){
                                Storage::delete('/public/media/'.$arrAttrImages[0]->attr_image);
                            }

                    }
                    $rand = rand('11111111','99999999');
                    $attr_image = $request->file("attr_image.$key");
                    $ext = $attr_image->extension();
                    $image_name = $rand.'.'.$ext;
                    $request->file("attr_image.$key")->storeAs('/public/media',$image_name);
                    $productAttrArr['attr_image']=$image_name;
                }
                if($paidArr[$key] != ''){
                    DB::table('product_attrib')->where(['id'=>$paidArr[$key]])->update($productAttrArr);
                }else{
                    $productAttrArr['attr_image']='';
                    DB::table('product_attrib')->insert($productAttrArr);
                }
            }
        }

        /*Product attribute*/

        /*Product images*/
            $piidArr = $request->post('piid');
            // echo'<pre>';
            // print_r($request->post());
            // die();
            foreach($piidArr as $key=>$val){
                $prodImageArr['product_id']=$prod_id;
                if($request->hasFile("images.$key")){
                    if($request->post('id')>0){
                        $arrImages = DB::table('product_images')->where(['id'=>$piidArr[$key]])->get();
                        if(!($arrImages->isEmpty())){
                        if(Storage::exists('/public/media/'.$arrImages[0]->images)){
                            Storage::delete('/public/media/'.$arrImages[0]->images);
                            }
                        }
                     }
                    $rand = rand('11111111','99999999');
                    $attr_image = $request->file("images.$key");
                    $ext = $attr_image->extension();
                    $image_name = $rand.'.'.$ext;
                    $request->file("images.$key")->storeAs('/public/media',$image_name);
                    $prodImageArr['images']=$image_name;
                }
                    if($piidArr[$key] != ''){
                        DB::table('product_images')->where(['id'=>$piidArr[$key]])->update($prodImageArr);
                    }else{
                        DB::table('product_images')->insert($prodImageArr);
                    }
            }

        /*Product images*/


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
        $arrAttrImages = DB::table('product_attrib')->where(['id'=>$paId])->get();
        if(Storage::exists('/public/media/'.$arrAttrImages[0]->attr_image)){
            Storage::delete('/public/media/'.$arrAttrImages[0]->attr_image);
        }
        DB::table('product_attrib')->where(['id'=>$paId])->delete();
        return redirect('admin/product/manage_product/'.$pId);
    }
    public function product_image_delete(Request $request,$pIId,$pId){
        $arrImages = DB::table('product_images')->where(['id'=>$pIId])->get();
        if(Storage::exists('/public/media/'.$arrImages[0]->images)){
            Storage::delete('/public/media/'.$arrImages[0]->images);
        }
        DB::table('product_images')->where(['id'=>$pIId])->delete();
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
