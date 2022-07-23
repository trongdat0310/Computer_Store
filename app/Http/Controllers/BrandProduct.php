<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else
            return Redirect::to('admin')->send();
    }
    public function add_brand_product(){
        $this->AuthLogin();
        return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();

        $all_brand_product = Brand::all();

        return view('admin.all_brand_product')
            ->with(compact('all_brand_product'));

//        $manager_brand_product = view('admin.all_brand_product')
//            ->with('all_brand_product',$all_brand_product);
//
//        return view('admin_layout')
//            ->with('admin.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this->AuthLogin();

        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['meta_keyword'] = $request->brand_product_keyword;
        $data['brand_desc'] = $request->brand_product_desc;
        $data['brand_status'] = $request->brand_product_status;

        Brand::query()
            ->create($data);

        Session::put('message','Thêm Thương hiệu sản phẩm thành công');

        return Redirect::to('all-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->AuthLogin();

        Brand::query()
            ->where('brand_id',$brand_product_id)
            ->update(['brand_status'=>1]);

        Session::put('message','Hiện Thương hiệu sản phẩm thành công');

        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->AuthLogin();

        Brand::query()
            ->where('brand_id',$brand_product_id)
            ->update(['brand_status'=>0]);

        Session::put('message','Ẩn Thương hiệu sản phẩm thành công');

        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();

        $edit_brand_product = Brand::query()
//            ->find(['brand_id'[], $brand_product_id);
            ->where('brand_id',$brand_product_id)
            ->first();

        $manager_brand_product = view('admin.edit_brand_product')
            ->with('edit_brand_product',$edit_brand_product);

        return view('admin_layout')
            ->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();

        Brand::query()
            ->where('brand_id',$brand_product_id)
            ->delete();

        Session::put('message','Xóa Thương hiệu sản phẩm thành công');

        return Redirect::to('all-brand-product');
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->AuthLogin();

        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['meta_keyword'] = $request->brand_product_keyword;
        $data['brand_desc'] = $request->brand_product_desc;

        Brand::query()
            ->where('brand_id',$brand_product_id)
            ->update($data);

        Session::put('message','Cập nhập Thương hiệu sản phẩm thành công');

        return Redirect::to('all-brand-product');
    }
    // End Functon Admin page

    public function show_brand_home(Request $request, $brand_id){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Sắp xếp theo thương hiệu";
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

        $product_of_brand = Product::query()
            ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
            ->where('tbl_product.brand_id',$brand_id)
            ->orderBy('product_id','desc')
            ->get();

        $brand_name = Brand::query()
            ->where('brand_id',$brand_id)
            ->limit(1)
            ->first();

        return view('pages.brand.show_brand')
            ->with('cate_product',$cate_product)
            ->with('brand_product',$brand_product)
            ->with('brand_name',$brand_name)
            ->with('product_of_brand',$product_of_brand)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keyword', $meta_keyword)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical);
    }
}
