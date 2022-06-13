<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $result['data'] = Size::all();
        return view('admin.size',$result);
    }

    public function manage_size(Request $request, $id=''){
        if($id>0){
            $arr = Size::where(['id'=>$id])->get();
            $result['size'] = $arr['0']->size;
            $result['id'] = $arr['0']->id;

        }else{
            $result['size'] = '';
            $result['id'] = 0;
        }
        return view('admin.manage_size',$result);
    }
    public function manage_size_process(Request $request){
        $request->validate([
            'size'=>'required|unique:sizes,size,'.$request->post('id'),
        ]);
        if($request->post('id')>0){
            $size = Size::find($request->post('id'));
            $msg = "Size Updated";
        }else{
            $size = new Size();
            $msg = "Size Added";
        }
       $size->size = $request->post('size');
       $size->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/size');
    }
    public function delete(Request $request, $id){
       $size = Size::find($id);
       $size->delete();
        $request->session()->flash('message','Size Deleted');
        return redirect('admin/size');
    }
    public function status(Request $request, $status,$id)
    {
        $size = Size::find($id);
        $size->status = $status;
        $size->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/size');

    }
}
