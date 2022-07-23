<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SendmailControler;
use App\Http\Controllers\Cart;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Fontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);

//Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class, 'show_category_home']);

//Thương hiệu sản phẩm trang chủ
Route::get('/thuong-hieu-san-pham/{brand_id}', [BrandProduct::class, 'show_brand_home']);

//Chi tiết sản phẩm
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'details_product']);

//Backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

//Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

//Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);

// Product
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

//Tìm kiếm sản phẩm
Route::post('/tim-kiem', [ProductController::class, 'search']);

//Giỏ hàng sản phẩm
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);
Route::get('/delete-all-cart', [CartController::class, 'delete_all_cart']);
//Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
//Route::get('/show-cart-ajax', [CartController::class, 'show_cart_ajax']);
Route::post('/add-cart-ajax',[CartController::class, 'add_cart_ajax']);
Route::get('/gio-hang',[CartController::class, 'gio_hang']);

//coupon
Route::post('/check-coupon', [CouponController::class, 'check_coupon']);
Route::get('/add-coupon', [CouponController::class, 'add_coupon']);
Route::post('/save-coupon', [CouponController::class, 'save_coupon']);
Route::get('/all-coupon', [CouponController::class, 'all_coupon']);
Route::get('/delete-coupon', [CouponController::class, 'delete_coupon']);

//Checkout
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/show-checkout', [CheckoutController::class, 'show_checkout']);

Route::post('/select-delivery-home',[CheckoutController::class, 'select_delivery_home']);
Route::post('/caculate-fee',[CheckoutController::class, 'caculate_fee']);
Route::post('/confirm-order',[CheckoutController::class, 'confirm_order']);
Route::get('/delete-fee',[CheckoutController::class, 'delete_fee']);


Route::get('/manager-order', [OrderController::class, 'manager_order']);
Route::get('/details-order/{order_code}', [OrderController::class, 'details_order']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);

//manager_order
//Route::get('/manager-order', [CheckoutController::class, 'manager_order']);
//Route::get('/view-order/{orderId}', [CheckoutController::class, 'view_order']);

//send_mail
Route::get('/send-mail', [SendmailControler::class, 'sendmail']);

//Login facebook
Route::get('/login-facebook',[AdminController::class, 'login_facebook']);
Route::get('/admin/callback',[AdminController::class, 'callback_facebook']);

//Login  google
Route::get('/login-google',[AdminController::class, 'login_google']);
Route::get('/google/callback',[AdminController::class, 'callback_google']);

//Delivery
Route::get('/delivery',[DeliveryController::class, 'delivery']);
Route::post('/select-delivery',[DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery',[DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship',[DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery',[DeliveryController::class, 'update_delivery']);

//Slider
Route::get('/slider',[SliderController::class, 'slider']);
Route::get('/add-slider',[SliderController::class, 'add_slider']);
Route::post('/save-slider',[SliderController::class, 'save_slider']);

Route::get('/unactive-slider/{slider_id}', [SliderController::class, 'unactive_slider']);
Route::get('/active-slider/{slider_id}', [SliderController::class, 'active_slider']);




