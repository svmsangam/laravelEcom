<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $result['data'] = Color::all();
        return view('admin.color',$result);
    }

    public function manage_color(Request $request, $id=''){
        if($id>0){
            $arr = Color::where(['id'=>$id])->get();
            $result['color'] = $arr['0']->color;
            $result['id'] = $arr['0']->id;

        }else{
            $result['color'] = '';
            $result['id'] = 0;
        }
        return view('admin.manage_color',$result);
    }
    public function manage_color_process(Request $request){
        $request->validate([
            'color'=>'required|unique:colors,color,'.$request->post('id'),
        ]);
        if($request->post('id')>0){
            $color = Color::find($request->post('id'));
            $msg = "Color Updated";
        }else{
            $color = new color();
            $msg = "Color Added";
        }
       $color->color = $request->post('color');
       $color->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/color');
    }
    public function delete(Request $request, $id){
       $color = Color::find($id);
       $color->delete();
        $request->session()->flash('message','Color Deleted');
        return redirect('admin/color');
    }
    public function status(Request $request, $status,$id)
    {
        $color = Color::find($id);
        $color->status = $status;
        $color->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/color');

    }
}
