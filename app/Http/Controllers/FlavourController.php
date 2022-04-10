<?php

namespace App\Http\Controllers;

use App\Models\Flavour;
use Illuminate\Http\Request;

class FlavourController extends Controller
{
    public function index()
    {
        $result['data'] = Flavour::all();
        return view('admin.flavour',$result);
    }

    public function manage_flavour(Request $request, $id=''){
        if($id>0){
            $arr = Flavour::where(['id'=>$id])->get();
            $result['flavour'] = $arr['0']->flavour;
            $result['id'] = $arr['0']->id;

        }else{
            $result['flavour'] = '';
            $result['id'] = 0;
        }
        return view('admin.manage_flavour',$result);
    }
    public function manage_flavour_process(Request $request){
        $request->validate([
            'flavour'=>'required|unique:flavours,flavour,'.$request->post('id'),
        ]);
        if($request->post('id')>0){
            $flavour = Flavour::find($request->post('id'));
            $msg = "Flavour Updated";
        }else{
            $flavour = new Flavour();
            $msg = "Flavour Added";
        }
       $flavour->flavour = $request->post('flavour');
       $flavour->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/flavour');
    }
    public function delete(Request $request, $id){
       $flavour = Flavour::find($id);
       $flavour->delete();
        $request->session()->flash('message','Flavour Deleted');
        return redirect('admin/flavour');
    }
    public function status(Request $request, $status,$id)
    {
        $flavour = Flavour::find($id);
        $flavour->status = $status;
        $flavour->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/flavour');

    }
}
