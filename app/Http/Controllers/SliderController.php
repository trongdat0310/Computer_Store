<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    public function slider(){
//        $this->AuthLogin();

        $all_slider = Slider::query()
            ->orderBy('slider_id','desc')
            ->paginate(6);

        return view('admin.slider.all_slider')
            ->with(compact('all_slider'));
    }
    public function add_slider(){
//        $this->AuthLogin();

        return view('admin.slider.add_slider');
    }
    public function save_slider(Request $request){
//        $this->AuthLogin();

        $data = array();
        $data['slider_name'] = $request->slider_name;
        $data['slider_desc'] = $request->slider_desc;
        $data['slider_status'] = $request->slider_status;
        $data['slider_image'] = $request->slider_image;

        $get_image = $request->file('slider_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider',$new_image);
            $data['slider_image'] = $new_image;

            Slider::query()
                ->insert($data);

            Session::put('message','Thêm slider thành công');

            return Redirect::to('slider');
        }

        $data['slider_image'] = '';
        Slider::query()
            ->insert($data);

        Session::put('message','Thêm slider thành công');

        return Redirect::to('slider');
    }
    public function unactive_slider($slider_id){
//        $this->AuthLogin();

        Slider::query()
            ->where('slider_id',$slider_id)
            ->update(['slider_status'=>1]);

        Session::put('message','Hiện slider thành công');

        return Redirect::to('slider');
    }
    public function active_slider($slider_id){
//        $this->AuthLogin();

        Slider::query()
            ->where('slider_id',$slider_id)
            ->update(['slider_status'=>0]);

        Session::put('message','Ẩn slider thành công');

        return Redirect::to('slider');
    }
}
