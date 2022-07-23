<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Customer;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Shipping;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Slider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else
            return Redirect::to('admin')->send();
    }
    public function login_checkout(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Đăng nhập";
        $url_canonical = $request->url();
        //--SEO

        $cate_product = Category::query()
            ->where('category_status','1')
            ->orderBy('category_id','desc')
            ->get();
        $brand_product = Brand::query()
            ->where('brand_status','1')
            ->orderBy('brand_id','desc')
            ->get();
        $slider = Slider::query()
            ->where('slider_status','1')
            ->orderBy('slider_id','desc')
            ->get();

        return view('pages.checkout.login_checkout')
            ->with(compact(
                'cate_product',
                'brand_product',
                'slider',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical'
            ));
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = Customer::query()
            ->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);

        return Redirect::to('/checkout');
    }
    public function checkout(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Điền thông tin thanh toán";
        $url_canonical = $request->url();
        //--SEO

        $cate_product = Category::query()
            ->where('category_status','1')
            ->orderBy('category_id','desc')
            ->get();
        $brand_product = Brand::query()
            ->where('brand_status','1')
            ->orderBy('brand_id','desc')
            ->get();
        $city = City::query()
            ->orderBy('city_id','ASC')
            ->get();
        $slider = Slider::query()
            ->where('slider_status','1')
            ->orderBy('slider_id','desc')
            ->get();
        return view('pages.checkout.show_checkout')
            ->with(compact(
                'cate_product',
                'brand_product',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical',
                'city',
                'slider'
            ));
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_note'] = $request->shipping_note;

        $shipping_id = Shipping::query()
            ->insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/payment');
    }
    public function payment(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Thanh toán";
        $url_canonical = $request->url();
        //--SEO

        $cate_product = Category::query()
            ->where('category_status','1')
            ->orderBy('category_id','desc')
            ->get();
        $brand_product = Brand::query()
            ->where('brand_status','1')
            ->orderBy('brand_id','desc')
            ->get();
        $slider = Slider::query()
            ->where('slider_status','1')
            ->orderBy('slider_id','desc')
            ->get();

        return view('pages.checkout.payment')
            ->with(compact(
                'cate_product',
                'brand_product',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical',
                'slider'
            ));
    }
    public function logout_checkout(){
        Session::flush();
        return Redirect('/login-checkout');
    }
    public function login_customer(Request $request){
        $email= $request->email_accout;
        $password = md5($request->password_accout);

        $result = Customer::query()
            ->where('customer_email',$email)
            ->where('customer_password',$password)
            ->first();

        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/');
        }else{
            return Redirect::to('/login-checkout');
        }
    }
    public function order_place(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Thanh toán";
        $url_canonical = $request->url();
        //--SEO

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['order_status'] = 'Đang chờ xử lý';

        $order_id = Order::query()
            ->insertGetId($order_data);

        //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_sales_quantity'] = $v_content->qty;

            $order_d_id = Order_details::query()
                ->insertGetId($order_d_data);
        }


    }
    public function manager_order(){
        $this->AuthLogin();
        $all_order = Order::query()
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderBy('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.manager_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manager_order', $manager_order);
    }
    public function view_order($orderId)
    {
        $this->AuthLogin();
        $order_by_id = Order::query()
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')
        ->where('tbl_order.order_id',$orderId)
        ->first();

        $order_d=Order_details::query()
            ->where('order_id',$orderId)
            ->get();

        $manager_order_by_id = view('admin.view_order')
            ->with('order_by_id',$order_by_id)
            ->with('order_d',$order_d);

        return view('admin_layout')
            ->with('admin.view_order', $manager_order_by_id);
    }

    public function select_delivery_home(Request $request){
        $data = $request->all();
        if ($data['action']){
            $output = '';
            if ($data['action'] == 'city'){
                $select_province = Province::query()
                    ->where('city_id',$data['ma_id'])
                    ->orderBy('province_id','ASC')
                    ->get();
                $output .= '
                    <option value="0">---Chọn Quận Huyện---</option>
                    ';
                foreach ($select_province as $province){
                    $output .= '
                    <option value="'.$province->province_id.'">'.$province->province_name.'</option>
                    ';
                }
            }elseif($data['action'] == 'province'){
                $select_wards = Wards::query()
                    ->where('province_id',$data['ma_id'])
                    ->orderBy('wards_id','ASC')
                    ->get();
                $output .= '
                    <option value="0">---Chọn Xã Phường---</option>
                    ';
                foreach ($select_wards as $wards){
                    $output .= '<option value="'.$wards->wards_id.'">'.$wards->wards_name.'</option>';
                }
            }
            echo $output;
        }
    }

    public function caculate_fee(Request $request){
        $data = $request->all();
        if ($data['matp']){
            $feeship = Feeship::query()
                ->where('city_id', $data['matp'])
                ->where('province_id', $data['maqh'])
                ->where('wards_id', $data['maxp'])
                ->first();
            if ($feeship){
                Session::put('fee', $feeship->fee_feeship);
                Session::save();
            }else{
                Session::put('fee', 25000);
                Session::save();
            }


        }
    }

    public function delete_fee(){
        $feeship = Session::get('fee');
        if ($feeship == true){
            Session::forget('fee');
            return redirect()->back()
                ->with('error','Xóa phí ship thành công');
        }
    }

    public function confirm_order(Request $request){
        $data = $request->all();

        $shipping = array();
        $shipping['shipping_name'] = $data['shipping_name'];
        $shipping['shipping_email'] = $data['shipping_email'];
        $shipping['shipping_address'] = $data['shipping_address'];
        $shipping['shipping_phone'] = $data['shipping_phone'];
        $shipping['shipping_note'] = $data['shipping_note'];
        $shipping['shipping_method'] = $data['shipping_method'];

        $shipping_id = Shipping::query()
            ->insertGetId($shipping);

        $order_code = substr(md5(microtime()),rand(0,26),5);

        $order = new Order();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->customer_id = Session::get('customer_id');;
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $order_code;
        $order->coupon_code = $data['order_coupon'];
        $order->order_fee = $data['order_fee'];
        $order->save();

        if (Cart::content()){
            foreach(Cart::content() as $cart){
                $order_details = new Order_details();
                $order_details->order_code = $order_code;
                $order_details->product_id = $cart->id;
                $order_details->product_sales_quantity = $cart->qty;
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Cart::destroy();
    }
}
