<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else
            return Redirect::to('admin')->send();
    }
    public function add_product(){
        $this->AuthLogin();

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

        return view('admin.add_product')
            ->with(compact(
                'cate_product',
                'brand_product',
                'slider'
            ));
    }
    public function all_product(){
        $this->AuthLogin();

        $all_product = Product::query()
            ->orderBy('product_id','desc')
            ->paginate(6);

        return view('admin.all_product')
            ->with(compact('all_product'));

//        $manager_product = view('admin.all_product')
//            ->with('all_product',$all_product);
//
//        return view('admin_layout')
//            ->with('admin.all_product',$manager_product);
    }
    public function save_product(Request $request){
        $this->AuthLogin();

        $data = array();
        $data['category_id'] = $request->product_cate;
        $data['Brand_id'] = $request->product_brand;
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_image;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;

            Product::query()
                ->insert($data);

            Session::put('message','Thêm sản phẩm thành công');

            return Redirect::to('all-product');
        }

        $data['product_image'] = '';
        Product::query()
            ->insert($data);

        Session::put('message','Thêm sản phẩm thành công');

        return Redirect::to('all-product');
    }
    public function unactive_product($product_id){
        $this->AuthLogin();

        Product::query()
            ->where('product_id',$product_id)
            ->update(['product_status'=>1]);

        Session::put('message','Hiện Thương hiệu sản phẩm thành công');

        return Redirect::to('all-product');
    }
    public function active_product($product_id){
        $this->AuthLogin();

        Product::query()
            ->where('product_id',$product_id)
            ->update(['product_status'=>0]);

        Session::put('message','Ẩn Thương hiệu sản phẩm thành công');

        return Redirect::to('all-product');
    }
    public function edit_product($product_id){
        $this->AuthLogin();

        $cate_product = Category::query()
            ->where('category_status','1')
            ->get();
        $brand_product = Brand::query()
            ->where('brand_status','1')
            ->get();

        $edit_product = Product::query()
            ->where('product_id',$product_id)
            ->first();

        $manager_product = view('admin.edit_product')
            ->with('edit_product',$edit_product)
            ->with('cate_product',$cate_product)
            ->with('brand_product',$brand_product);

        return view('admin_layout')
            ->with('admin.edit_product',$manager_product);
    }
    public function delete_product($product_id){
        $this->AuthLogin();

        Product::query()
            ->where('product_id',$product_id)
            ->delete();

        Session::put('message','Xóa sản phẩm thành công');

        return Redirect::to('all-product');
    }
    public function update_product(Request $request,$product_id){
        $this->AuthLogin();

        $data = array();
        $data['category_id'] = $request->product_cate;
        $data['Brand_id'] = $request->product_brand;
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;

            Product::query()
                ->where('product_id',$product_id)
                ->update($data);

            Session::put('message','Cập nhật sản phẩm thành công');

            return Redirect::to('all-product');
        }
        Product::query()
            ->where('product_id',$product_id)
            ->update($data);

        Session::put('message','Cập nhật sản phẩm thành công');

        return Redirect::to('all-product');
    }
    //End Function Admin

    public function details_product(Request $request, $product_id){

        $cate_product = Category::query()
            ->where('category_status','1')
            ->orderBy('category_id','desc')
            ->get();
        $brand_product = Brand::query()
            ->where('brand_status','1')
            ->orderBy('brand_id','desc')
            ->get();

        $details_product = Product::query()
            ->where('product_id',$product_id)
            ->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            //SEO
            $meta_desc = $value->product_desc;
            $meta_keyword = $value->product_slug;
            $meta_title = $value->product_name;;
            $url_canonical = $request->url();
            //--SEO
        }

        $related_product = Product::query()
            ->join('tbl_category_product','tbl_category_product.category_id','tbl_product.category_id')
            ->where('tbl_category_product.category_id',$category_id)
            ->whereNotIn('product_id',[$product_id]) //whereNotIn : trừ ra sản phẩm được chọn
            ->limit(3)
            ->get();

        return view('pages.product.show_details')
            ->with(compact(
                'cate_product',
                'brand_product',
                'related_product',
                'details_product',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical'
            ));
    }
    public function search(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Tìm kiếm";
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

        $keywords = $request->keywords_submit;

        $search_product = Product::query()
            ->where('product_name','like','%' .$keywords. '%')
            ->get();

        return view('pages.product.search')
            ->with(compact(
                'cate_product',
                'brand_product',
                'slider',
                'search_product',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical'));
    }
}
