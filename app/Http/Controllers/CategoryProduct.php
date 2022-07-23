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

class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else
            return Redirect::to('admin')->send();
    }
    public function add_category_product(){
        $this->AuthLogin();
        return view('admin.add_category_product');
    }
    public function all_category_product(){
        $this->AuthLogin();

        $all_category_product = Category::all();

        return view('admin.all_category_product')
            ->with(compact('all_category_product'));

//        $manager_category_product = view('admin.all_category_product')
//            ->with('all_category_product',$all_category_product);
//
//        return view('admin_layout')
//            ->with('admin.all_category_product',$manager_category_product);
    }
    public function save_category_product(Request $request){
        $this->AuthLogin();

        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['meta_keyword'] = $request->category_product_keyword;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;

        Category::query()
            ->create($data);

        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();

        Category::query()
            ->where('category_id',$category_product_id)
            ->update(['category_status'=>1]);

        Session::put('message','Hiện danh mục sản phẩm thành công');

        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id){
        $this->AuthLogin();

        Category::query()
            ->where('category_id',$category_product_id)
            ->update(['category_status'=>0]);

        Session::put('message','Ẩn danh mục sản phẩm thành công');

        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id){
        $this->AuthLogin();

        $edit_category_product = Category::query()
            ->where('category_id',$category_product_id)
            ->first();

        $manager_category_product = view('admin.edit_category_product')
            ->with('edit_category_product',$edit_category_product);

        return view('admin_layout')
            ->with('admin.edit_category_product',$manager_category_product);
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();

        Category::query()
            ->where('category_id',$category_product_id)
            ->delete();

        Session::put('message','Xóa danh mục sản phẩm thành công');

        return Redirect::to('all-category-product');
    }
    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();

        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['meta_keyword'] = $request->category_product_keyword;
        $data['category_desc'] = $request->category_product_desc;

        Category::query()
            ->where('category_id',$category_product_id)
            ->update($data);

        Session::put('message','Cập nhập danh mục sản phẩm thành công');

        return Redirect::to('all-category-product');
    }
    // End Functon Admin page

    public function show_category_home(Request $request, $category_id){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Sắp xếp theo danh mục";
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

        $product_of_category = Product::query()
            ->join('tbl_category_product','tbl_category_product.category_id','tbl_product.category_id')
            ->where('tbl_product.category_id',$category_id)
            ->orderBy('product_id','desc')
            ->paginate(6);

        $category_name = Category::query()
            ->where('tbl_category_product.category_id',$category_id)
            ->limit(1)
            ->first();

        return view('pages.category.show_category')
            ->with(compact(
                'cate_product',
                'brand_product',
                'category_name',
                'slider',
                'product_of_category',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical'
            ));
    }

}
