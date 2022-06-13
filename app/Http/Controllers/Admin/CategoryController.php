<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data'] = Category::all();
        return view('admin.category',$result);
    }

    public function manage_category(Request $request, $id=''){
        if($id>0){
            $arr = Category::where(['id'=>$id])->get();
            $result['category_name'] = $arr['0']->category_name;
            $result['slug'] = $arr['0']->slug;
            $result['parent_category_id'] = $arr['0']->parent_category_id;
            $result['category_image'] = $arr['0']->category_image;
            $result['showOnHome'] = $arr['0']->showOnHome;   
            $result['id'] = $arr['0']->id;
            if($arr[0]->showOnHome==1){
                $result['checkHome'] = 'checked';
            }else{
            $result['checkHome'] = '';
            }
            $result['category'] = DB::table('categories')
            ->where(['status'=>1])
            ->where('id', '!=', $id)
            ->get();

        }else{
            $result['category'] = DB::table('categories')->where(['status'=>1])->get();
            $result['category_name'] = '';
            $result['category_image']='';
            $result['slug'] = '';
            $result['showOnHOme'] = '';
            $result['checkHome'] = '';
            $result['parent_category_id'] = '';
            $result['id'] = 0;
        }
        return view('admin.manage_category',$result);
    }
    public function manage_category_process(Request $request){
        $request->validate([
            'category_name' => 'required',
            'slug'=>'required|unique:categories,slug,'.$request->post('id'),
            'category_image'=>'mimes:jpeg,jpg,png'
        ]);
        if($request->post('id')>0){
            $category = Category::find($request->post('id'));
            $msg = "Category Updated";
        }else{
            $category = new Category();
            $msg = "Category added";
        }

        if($request->hasFile("category_image")){
            if($request->post('id')>0){
                $arrCatImages = DB::table('categories')->where(['id'=>$request->post('id')])->get();
                if(Storage::exists('/public/media/categories/'.$arrCatImages[0]->category_image)){
                    Storage::delete('/public/media/categories/'.$arrCatImages[0]->category_image);
                }
            }
            $rand = rand('11111111','99999999');
            $category_image = $request->file("category_image");
            $ext = $category_image->extension();
            $image_name = $rand.'.'.$ext;
            $request->file("category_image")->storeAs('/public/media/categories',$image_name);
            $category->category_image = $image_name;     
        }
        $category->showOnHome = 0;
        if($request->post('showOnHome') !== null){
            // echo "<pre>";
            // print_r($request->post('showOnHome'));
            // die();
            $category->showOnHome = 1;
        }
        $category->category_name = $request->post('category_name');
        $category->slug = $request->post('slug');
        $category->parent_category_id = $request->post('parent_category_id');
        $category->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/category');
    }
    public function delete(Request $request, $id){
        $category = Category::find($id);
        $arrCatImages = DB::table('categories')->where(['id'=>$id])->get();
        // echo "<pre>";
        // print_r($arrCatImages);
        // die();
        if(Storage::exists('/public/media/categories/'.$arrCatImages[0]->category_image)){
            Storage::delete('/public/media/categories/'.$arrCatImages[0]->category_image);
        }
        $category->delete();
        $request->session()->flash('message','Category Deleted');
        return redirect('admin/category');
    }

    public function status(Request $request, $status,$id)
    {
        $category = Category::find($id);
        $category->status = $status;
        $category->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/category');

    }
}
