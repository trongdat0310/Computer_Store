<?php


namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Models\Coupon;
session_start();

class CouponController extends Controller
{
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::query()
            ->where('coupon_code', $data['coupon_code'])
            ->first();
        if ($coupon){
            $count_coupon = $coupon->count();
            if ($count_coupon > 0){
                $coupon_sesion = Session::get('coupon_array');
                if ($coupon_sesion == true){
                    $is_avalibale = 0;
                    if ($is_avalibale == 0){
                        $coupon_array[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
//                        'coupon_time' => $coupon -> coupon_code
                        );
                        Session::put('coupon_array', $coupon_array);
                    }
                }else{
                    $coupon_array[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
//                        'coupon_time' => $coupon -> coupon_code
                    );
                    Session::put('coupon_array', $coupon_array);
                }
                Session::save();
                return redirect()->back()
                    ->with('message','Thêm mã giảm giá thành công');
            }
        }else{
            return redirect()->back()
                ->with('error','Mã giảm giá không đúng');
        }
    }
    public function add_coupon(){
        return view('admin.coupon.add_coupon');
    }
    public function save_coupon(Request $request){
        $data = $request->all();
        $coupon = new Coupon();

        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_condition = $data['coupon_condition'];

        $coupon->save();

        Session::put('message','Thêm mã giảm giá thành công');

        return Redirect::to('all-coupon');

    }

    public function all_coupon(){
        $all_coupon = Coupon::all();
        return view('admin.coupon.all_coupon')
            ->with(compact('all_coupon'));
    }
    public function delete_coupon(){
        $coupon = Session::get('coupon_array');
        if ($coupon == true){
            Session::forget('coupon_array');
            return redirect()->back()
                ->with('error','Xóa mã giảm giá thành công');
        }
    }
}
