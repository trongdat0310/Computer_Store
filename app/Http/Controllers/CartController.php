<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Darryldecode\Cart\Cart as CartCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;

        if($request->qty){
            $quantity = $request->qty;
        }else{
            $quantity = 1;
        }

        $product_info = Product::query()
            ->where('product_id',$productId)
            ->get()
            ->first();

        $data = array();
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options'] ['image'] = $product_info->product_image;

        Cart::add($data);

        return Redirect::to('/show-cart');
    }

    public function show_cart(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Giỏ hàng";
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

        return view('pages.cart.show_cart')
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
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart')
            ->with('error','Xóa sản phẩm khỏi giỏ hàng thành công');
    }
    public function delete_all_cart(){
        Cart::destroy();
        return Redirect::to('/show-cart')
            ->with('error','Xóa tất cả sản phẩm khỏi giỏ hàng thành công');
    }
    public function gio_hang(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Giỏ hàng";
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

        return view('pages.cart.cart_ajax')
            ->with(
                compact(
                    'cate_product',
                    'brand_product',
                    'slider',
                    'meta_desc',
                    'meta_keyword',
                    'meta_title',
                    'url_canonical'
                ));
    }
    public function update_cart_quantity(Request $request){
        foreach (Cart::content() as $cart){
            $rowId = $request->rowId_cart;
            $qty = $request->cart_quantity;
            Cart::update($rowId,$qty);
        }

        return redirect()->back()
            ->with('message','Cập nhập giỏ hàng thành công');
    }
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }

        Session::save();

    }



}
