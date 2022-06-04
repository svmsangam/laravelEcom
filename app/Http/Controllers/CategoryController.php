<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $result['id'] = $arr['0']->id;
            $result['category'] = DB::table('categories')
            ->where(['status'=>1])
            ->where('id', '!=', $id)
            ->get();

        }else{
            $result['category'] = DB::table('categories')->where(['status'=>1])->get();
            $result['category_name'] = '';
            $result['category_image']='';
            $result['slug'] = '';
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
            $rand = rand('11111111','99999999');
            $category_image = $request->file("category_image");
            $ext = $category_image->extension();
            $image_name = $rand.'.'.$ext;
            $request->file("category_image")->storeAs('/public/media/categories',$image_name);
            $category->category_image = $image_name;     
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
