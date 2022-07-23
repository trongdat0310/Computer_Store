<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(Request $request){
        //SEO
        $meta_desc = "Phụ kiện máy tính và máy tính mới nhất";
        $meta_keyword = "phụ kiện máy tính, máy tính";
        $meta_title = "Gear-VN";
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

        $all_product = Product::query()
            ->where('product_status','1')
            ->orderBy('product_id','desc')
            ->paginate(6);

        return view('pages.home')
            ->with(compact(
                'cate_product',
                'brand_product',
                'slider',
                'all_product',
                'meta_desc',
                'meta_keyword',
                'meta_title',
                'url_canonical'
            ));
    }
}
