<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data'] = HomeBanner::all();
        return view('admin.banner',$result);
    }

    public function manage_banner(Request $request, $id=''){
        if($id>0){
            $arr = HomeBanner::where(['id'=>$id])->get();
            $result['image'] = $arr['0']->image;
            $result['btn_text'] = $arr['0']->btn_text;
            $result['btn_link'] = $arr['0']->btn_link;
            $result['id'] = $arr['0']->id;

        }else{
            $result['image'] = '';
            $result['btn_text'] = '';
            $result['btn_link'] = '';
            $result['id'] = '';
        }
        return view('admin.manage_banner',$result);
    }
    public function manage_banner_process(Request $request){
        $request->validate([
            'image'=>'mimes:jpeg,jpg,png',
            // 'btn_text'=>'required',
            // 'btn_link'=>'required',
        ]);
        if($request->post('id')>0){
            $banner = HomeBanner::find($request->post('id'));
            $msg = "Banner Updated";
        }else{
            $banner = new HomeBanner();
            $msg = "Banner Added";
        }
        if($request->hasFile("image")){
            if($request->post('id')>0){
                $arrBanImages = DB::table('home_banners')->where(['id'=>$request->post('id')])->get();
                if(Storage::exists('/public/media/banners/'.$arrBanImages[0]->image)){
                    Storage::delete('/public/media/banners/'.$arrBanImages[0]->image);
                }
            }
            $rand = rand('11111111','99999999');
            $banner_image = $request->file("image");
            $ext = $banner_image->extension();
            $image_name = $rand.'.'.$ext;
            $request->file("image")->storeAs('/public/media/banners',$image_name);
            $banner->image = $image_name;
        }     
       $banner->btn_text = $request->post('btn_text');
       $banner->btn_link = $request->post('btn_link');  
       $banner->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/banner');
    }
    public function delete(Request $request, $id){
       $banner = HomeBanner::find($id);
       $arrBanImages = DB::table('home_banners')->where(['id'=>$id])->get();
       if(Storage::exists('/public/media/banners/'.$arrBanImages[0]->image)){
           Storage::delete('/public/media/banners/'.$arrBanImages[0]->image);
       }
       $banner->delete();
        $request->session()->flash('message','Banner Deleted');
        return redirect('admin/banner');
    }
    public function status(Request $request, $status,$id)
    {
        $banner = HomeBanner::find($id);
        $banner->status = $status;
        $banner->save();
        $request->session()->flash('message','Status Updated');
        return redirect('admin/banner');

    }


}
