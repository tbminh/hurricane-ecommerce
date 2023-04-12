<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLogin;

//Trang chủ
Route::get('/', 'HomeController@index')->name('home');

//Trang category
Route::get('page-category','HomeController@page_category');

//Trang sản phẩm
Route::get('page-product/{id_category}','HomeController@page_product');


//Trang chi tiết sản phẩm
Route::get('page-product-detail/{id}','HomeController@page_product_detail');

//Trang tin tức
Route::get('page-news',function(){
    return view('home.page_news');
});

//Trang contact
Route::get('page-contact',function(){
    return view('home.page_contact');
});


//=========XỬ LÍ ĐĂNG KÝ ĐĂNG NHẬP ====================//
//Trang đăng ký
Route::get('page-sign-up','HomeController@page_sign_up');
//Trang đăng nhập
Route::get('page-login','HomeController@page_login');
//Hàm xử lí đăng ký
Route::post('post-sign-up','HomeController@post_sign_up');
//Hàm xử lí đăng nhập
Route::post('post-login','HomeController@post_login');
//Hàm xử lí đăng xuất
Route::get('logout','HomeController@logout');
//Đăng ký facebook
Route::get('facebook','HomeController@facebookRedirect');
Route::get('fb/callback','HomeController@loginWithFacebook');
//Đăng nhập bằng google
Route::get('google','HomeController@googleRedirect');
Route::get('gg/callback','HomeController@loginWithGoogle');
//============GIỎ HÀNG ==============//
//Trang giỏ hàng
Route::get('page-cart/{id_user}','HomeController@page_cart');
//Hàm thêm vào giỏ hàng
Route::get('add-cart/{id_user}/{id_product}','HomeController@add_cart');
//Thêm combo vào giỏ hàng
Route::get('add-combo-cart/{id_user}/{id_combo}','HomeController@add_combo_cart');
//Thêm chi tiết sp vào giỏ hàng
Route::post('add-cart-detail/{id}/{id_user}','HomeController@add_cart_detail');
//Hàm cập nhật số lượng trong giỏ hàng
Route::post('update-cart/{id_user}/{id_cart}','HomeController@update_cart');
//Hàm xóa sản phẩm trong giỏ hàng
Route::get('delete-product-cart/{id_cart}','HomeController@delete_product_cart');
//Trang thanh toán
Route::get('page-checkout/{id_user}','HomeController@page_checkout');
//Hàm thanh toán đơn hàng
Route::post('checkout-payment/{id_user}','HomeController@checkout_payment');
Route::post('sending-email','HomeController@post_feedback')->name('post.feedback');

//======THÔNG TIN KHÁCH HÀNG ======//
//Trang hồ sơ cá nhân khách hàng
Route::get('page-profile', 'HomeController@page_profile');
//Trang thay đổi thông tin khách hàng
Route::get('page-edit-user/{id_user}', 'HomeController@page_edit_user');
//Trang đổi mật khẩu người dùng
Route::get('page-change-password', 'HomeController@page_change_password');
//HÀM CẬP NHẬT MẬT KHẨU KHÁCH HÀNG
Route::post('update-password/{id_user}', 'HomeController@update_password');
//Trang chờ thanh toán
Route::get('page-wait-payment/{id_user}', 'HomeController@page_wait_payment');
//Trang đang giao hàng
Route::get('page-shipping/{id_user}', 'HomeController@page_shipping');
//Trang đã giao hàng
Route::get('page-complete/{id_user}', 'HomeController@page_complete');
//Trang đã hủy
Route::get('page-cancelled/{id_user}', 'HomeController@page_cancelled');

//=============================
//============================

//==========CHECK ĐĂNG NHẬP CHO ADMIN =========//
//Trang đăng nhập
Route::get('login-admin','AdminController@login_admin');
//Hàm kiểm tra đăng nhập quản trị viên
Route::post('check-login','AdminController@check_login');
//Hàm đăng xuất
Route::get('logout-admin','AdminController@logout_admin');

//============================================== ADMIN ================================================//
Route::middleware([CheckLogin::class])->group(function () {

    //Trang admin
    Route::get('page-admin','AdminController@page_admin');

    //=======QUẢN LÝ HỒ SƠ QUẢN TRỊ VIÊN - NHÂN VIÊN =================//
    //Hiển thị profile admin
    Route::get('profile-admin/{id_user}', 'AdminController@profile_admin');
    //Cập nhật thông tin admin
    Route::put('update-profile/{id_user}', 'AdminController@update_profile');
    //Trang thay đổi mật khẩu quản trị viên
    Route::get('change-pass/{id_user}', 'AdminController@change_pass');
    //Thay đổi mật khẩu quản trị viên
    Route::post('update-change-password/{id_user}', 'AdminController@update_change_password');

    //=====QUẢN LÝ QUYỀN TRUY CẬP ====//
    //Trang role_access
    Route::get('page-role-access','AdminController@page_role_access');
    
    //Hàm thêm quyền truy cập
    Route::post('post-add-role-access','AdminController@post_add_role_access');
    //Trang thay đổi quyền truy cập
    Route::get('page-change-role/{id_role}', 'AdminController@page_change_role');
    //Hàm đổi quyền truy cập CSDL
    Route::put('update-role/{id_user}', 'AdminController@update_role');
    //Quản trị viên
    Route::get('page-administation', 'AdminController@page_administation');
    //Trang thêm quản trị viên
    Route::get('page-add-admin', 'AdminController@page_add_admin');
    //== HÀM THÊM MỚI QUẢN TRỊ-NHÂN VIÊN-KHÁCH HÀNG ==//
    Route::post('post-add-admin', 'AdminController@post_admin');
    //Nhân viên
    Route::get('page-employee', 'AdminController@page_employee');
    //Xóa nhân viên
    Route::get('delete-employee/{id_employee}', 'AdminController@delete_employee');
    //Khách hàng
    Route::get('page-customer', 'AdminController@page_customer');
    //Hàm xóa khách hàng
    Route::get('delete-customer/{id_customer}','AdminController@delete_customer');

    //=======QUẢN LÝ SẢN PHẨM ======//
    //Trang loại sản phẩm
    Route::get('page-category-product', 'AdminController@page_category_product');
    Route::post('post-add-category', 'AdminController@post_add_category');
    Route::get('delete-category/{id_category}', 'AdminController@delete_category');
    Route::put('edit-category/{id_category}', 'AdminController@edit_category');
    Route::get('page-list-product', 'AdminController@page_list_product');
    Route::get('page-combo-product','AdminController@combo_product');
    //Trang thêm combo
    Route::post('add-combo', 'AdminController@add_combo');
    //Xóa combo
    Route::get('delete-combo/{id_combo}','AdminController@delete_combo');
    //Trang chi tiết combo
    Route::get('combo-detail/{id_combo}','AdminController@combo_detail');
    //Xóa combo detail
    Route::get('delete-product-combo/{id_detail}/{id_combo}','AdminController@delete_product_combo');
    //Thêm product vào combo 
    Route::post('post-add-cd/{id_combo}','AdminController@add_combo_detail');
    //Cập nhật lại tổng giá theo discount
    Route::get('update-discount/{key}/{dis}','AdminController@update_discount');
    //Lấy sản phẩm theo category bằng ajax
    Route::get('findProductName','AdminController@findProductName');

    //Hàm thêm sản phẩm CSDL
    Route::post('post-product', 'AdminController@post_product');

    //Thêm chi tiết sản phẩm
    Route::get('add-pdetail','AdminController@add_pdetail');
    //Xóa sản phẩm
    Route::get('delete-product/{id_product}','AdminController@delete_product');
    //Cập nhật thông tin sản phẩm
    Route::put('update-product/{id_product}/{id_pro_sub}', 'AdminController@update_product');
    //Nhà cung cấp
    Route::get('product-supplier', 'AdminController@product_supplier');
    //Hàm thêm nhà cung cấp CSDL
    Route::post('post-supplier', 'AdminController@post_supplier');
    //Trang chỉnh sửa nhà cung cấp
    Route::get('edit-supplier/{id_supplier}','AdminController@edit_supplier');
    //Hàm chỉnh sửa nhà cung cấp
    Route::put('update-supplier/{id_supplier}','AdminController@update_supplier');
    //Xóa nhà cung cấp
    Route::get('delete-supplier/{id_supplier}','AdminController@delete_supplier');

    //========QUẢN LÝ HÓA ĐƠN=====//
    //Trang hóa đơn 
    Route::get('admin-order', 'AdminController@admin_order');
    //Duyệt hóa đơn
    Route::get('approve-order/{id}', 'AdminController@approve_order');
    //Xác nhận đã giao hàng
    Route::get('confirm-order/{id}', 'AdminController@confirm_order');
    //Hủy đơn hàng đang vận chuyển
    Route::get('cancel-order/{id}', 'AdminController@cancel_order');
    //Chi tiết hóa đơn
    Route::get('admin-order-detail/{id}', 'AdminController@admin_order_detail');
    //Xuất hóa đơn
    Route::get('export-order/{id}', 'AdminController@export_order');
});


