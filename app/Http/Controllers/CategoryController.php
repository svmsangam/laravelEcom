<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
            $result['id'] = $arr['0']->id;

        }else{
            $result['category_name'] = '';
            $result['slug'] = '';
            $result['id'] = 0;
        }
        return view('admin.manage_category',$result);
    }
    public function manage_category_process(Request $request){
        $request->validate([
            'category_name' => 'required',
            'slug'=>'required|unique:categories,slug,'.$request->post('id'),
        ]);
        if($request->post('id')>0){
            $category = Category::find($request->post('id'));
            $msg = "Category Updated";
        }else{
            $category = new Category();
            $msg = "Category added";
        }
        $category->category_name = $request->post('category_name');
        $category->slug = $request->post('slug');
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
