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
        $request->session()->flash('message',$msg);
        return redirect('admin/product');
    }
    public function delete(Request $request, $id){
        $product = Product::find($id);
        $product->delete();
        $request->session()->flash('message','Product Deleted');
        return redirect('admin/product');
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
