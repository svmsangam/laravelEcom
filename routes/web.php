<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FlavourController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Front\FrontController;

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
//Front
Route::get('/',[FrontController::class,'index']);
Route::get('product/{slug}',[FrontController::class,'product']);
Route::post('/add_to_cart',[FrontController::class,'add_to_cart']);
Route::get('cart',[FrontController::class,'cart']);

//Admin
Route::get('admin',[AdminController::class,'index']);
Route::post('admin/auth',[AdminController::class,'auth'])->name('admin.auth');
Route::group(['middleware'=>'admin_auth'],function(){
    Route::get('admin/dashboard',[AdminController::class,'dashboard']);
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('success','Logout Successfully');
        return redirect('admin');
    });
    //Category
    Route::get('admin/category',[CategoryController::class,'index']);
    Route::get('admin/category/manage_category',[CategoryController::class,'manage_category']);
    Route::get('admin/category/manage_category/{id}',[CategoryController::class,'manage_category']);
    Route::post('admin/category/manage_category_process',[CategoryController::class,'manage_category_process'])->name('category.manage_category_process');
    Route::get('admin/category/delete/{id}',[CategoryController::class,'delete']);
    Route::get('admin/category/status/{status}/{id}',[CategoryController::class,'status']);
    
    //Coupon
    Route::get('admin/coupon',[CouponController::class,'index']);
    Route::get('admin/coupon/manage_coupon',[CouponController::class,'manage_coupon']);
    Route::get('admin/coupon/manage_coupon/{id}',[CouponController::class,'manage_coupon']);
    Route::post('admin/coupon/manage_coupon_process',[CouponController::class,'manage_coupon_process'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{id}',[CouponController::class,'delete']);
    Route::get('admin/coupon/status/{status}/{id}',[CouponController::class,'status']);

    //Size
    Route::get('admin/size',[SizeController::class,'index']);
    Route::get('admin/size/manage_size',[SizeController::class,'manage_size']);
    Route::get('admin/size/manage_size/{id}',[SizeController::class,'manage_size']);
    Route::post('admin/size/manage_size_process',[SizeController::class,'manage_size_process'])->name('size.manage_size_process');
    Route::get('admin/size/delete/{id}',[SizeController::class,'delete']);
    Route::get('admin/size/status/{status}/{id}',[SizeController::class,'status']);

    //Flavour
    Route::get('admin/flavour',[FlavourController::class,'index']);
    Route::get('admin/flavour/manage_flavour',[FlavourController::class,'manage_flavour']);
    Route::get('admin/flavour/manage_flavour/{id}',[FlavourController::class,'manage_flavour']);
    Route::post('admin/flavour/manage_flavour_process',[FlavourController::class,'manage_flavour_process'])->name('flavour.manage_flavour_process');
    Route::get('admin/flavour/delete/{id}',[FlavourController::class,'delete']);
    Route::get('admin/flavour/status/{status}/{id}',[FlavourController::class,'status']);

    //Color

    Route::get('admin/color',[ColorController::class,'index']);
    Route::get('admin/color/manage_color',[ColorController::class,'manage_color']);
    Route::get('admin/color/manage_color/{id}',[ColorController::class,'manage_color']);
    Route::post('admin/color/manage_color_process',[ColorController::class,'manage_color_process'])->name('color.manage_color_process');
    Route::get('admin/color/delete/{id}',[ColorController::class,'delete']);
    Route::get('admin/color/status/{status}/{id}',[ColorController::class,'status']);
    
    //Banner
    Route::get('admin/banner',[HomeBannerController::class,'index']);
    Route::get('admin/banner/manage_banner',[HomeBannerController::class,'manage_banner']);
    Route::get('admin/banner/manage_banner/{id}',[HomeBannerController::class,'manage_banner']);
    Route::post('admin/banner/manage_banner_process',[HomeBannerController::class,'manage_banner_process'])->name('banner.manage_banner_process');
    Route::get('admin/banner/delete/{id}',[HomeBannerController::class,'delete']);
    Route::get('admin/banner/status/{status}/{id}',[HomeBannerController::class,'status']);

    //Product
    Route::get('admin/product',[ProductController::class,'index']);
    Route::get('admin/product/manage_product',[ProductController::class,'manage_product']);
    Route::get('admin/product/manage_product/{id}',[ProductController::class,'manage_product']);
    Route::post('admin/product/manage_product_process',[ProductController::class,'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}',[ProductController::class,'delete']);
    Route::get('admin/product/status/{status}/{id}',[ProductController::class,'status']);


    //Product Attribute
    Route::get('admin/product/product_attr_delete/{paId}/{pId}',[ProductController::class,'product_attr_delete']);

    //Product Images
    Route::get('admin/product/product_images_delete/{pIId}/{pId}',[ProductController::class,'product_image_delete']);


    //Admin customer management
    Route::get('admin/customer',[CustomerController::class,'index']);
    Route::get('admin/customer/view_customer/{id}',[CustomerController::class,'view_customer']);
    Route::get('admin/customer/status/{status}/{id}',[CustomerController::class,'status']);


});
