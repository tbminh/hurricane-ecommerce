<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\RoleAccess;
Use Alert;
use App\Category;
use App\Product;
use App\Order;
use App\OrderDetail;
use App\OrderTable;
use App\OtDetail;
use App\ShoppingCart;
use App\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //Trang chủ
    public function index(){
        return view('home.index');
    }

    //Trang xử lí đăng ký
    public function post_sign_up(Request $request){
        $this->validate($request,[
            'user_name'=>'unique:users,user_name'
        ],[
            'user_name.unique'=>'Tên tài khoản đã tồn tại!'
        ]
        );

        $add_sign_up = new User();
        $add_sign_up->role_id  = 3;
        $add_sign_up->full_name = $request->input('full_name');
        $add_sign_up->user_name = $request->input('user_name');
        $add_sign_up->password = bcrypt($request->input('password'));
        $add_sign_up->email = $request->input('email');
        $add_sign_up->address = $request->input('address');
        $add_sign_up->phone = $request->input('phone');
        $add_sign_up->save();
        return redirect('page-login')->with('alert', 'Đăng ký tài khoản thành công! Vui lòng đăng nhập');
    }

    //Hàm xử lí đăng nhập
    public function post_login(Request $request){
        $user_name = $request->input('user_name');
        $password = $request->input('password');

        if(Auth::attempt(['user_name' => $user_name, 'password' => $password, 'role_id' => 3])){
            return redirect('/')->with('message1','');
        }else{
            $message = $request->session()->get('message2');
            return redirect()->back()->with('message2','');
        }
    }

    // Hàm xử lí đăng xuất
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    //Trang đăng ký
    public function page_sign_up(){
        return view('home.page_sign_up');
    }

    //Trang đăng nhập
    public function page_login(){
        return view('home.page_login');
    }

    //Trang giỏ hàng
    public function page_cart($id_user){
        $show_carts = ShoppingCart::where('user_id',$id_user)->get();
        return view('home.page_cart',['show_carts'=> $show_carts]);
    }
    
    //=================THÔNG TIN KHÁCH HÀNG ===============//
    //Trang hồ sơ khách hàng
    public function page_profile(){
        return view('home.profile_user.page_profile');
    }

    //Trang thay đổi thông tin khách hàng
    public function page_edit_user($id_user){
        $edit_user = User::find($id_user);
        return view('home.profile_user.page_edit_user', ['edit_user'=>$edit_user]);
    }


    //Trang đổi mật khẩu người dùng
    public function page_change_password()
    {
        return view('home.profile_user.change_password');
    }

    //HÀM ĐỔI MẬT KHẨU NGƯỜI DÙNG
    public function update_password(Request $request, $id_user)
    {
        $users = DB::table('users')->where('id', $id_user)->get();

        $old_pass = $request->input('inputPassOld');
        $new_pass = $request->input('inputPassNew');
        $new_pass_confirm = $request->input('inputPassComfirm');

        $change = User::find($id_user);

        foreach($users as $val_users){
            //Lấy mật khẩu trong DB lưu vào biến
            $db_pass = $val_users->password;

            if(password_verify($old_pass,$db_pass)){
                if($new_pass == $new_pass_confirm){
                    $change->password = bcrypt($request->input('inputPassComfirm'));
                    $change->save();
                    return redirect()->back()->with('message','');
                }else{
                    return redirect()->back()->with('message1','');
                }
            }else{
                return redirect()->back()->with('message2','');
            }
        }
    }

    //Trang chờ xác nhận
    public function page_wait_payment($id_user){
        $show_orders = Order::where([['user_id', $id_user], ['order_status', 0]])->latest()->paginate(2);
        return view('home.profile_user.wait_payment', ['show_orders'=>$show_orders]);
    }

    //Trang chờ đang giao hàng
    public function page_shipping($id_user){
        $show_orders = Order::where([['user_id', $id_user], ['order_status', 1]])->latest()->paginate(2);
        return view('home.profile_user.page_shipping', ['show_orders'=>$show_orders]);
    }

    //Trang chờ đã giao hàng
    public function page_complete($id_user){
        $show_orders = Order::where([['user_id', $id_user], ['order_status', 2]])->latest()->paginate(2);
        return view('home.profile_user.page_complete', ['show_orders'=>$show_orders]);
    }

    //Trang đã hủy
    public function page_cancelled($id_user){
        $show_orders = Order::where([['user_id', $id_user], ['order_status', 3]])->latest()->paginate(2);
        return view('home.profile_user.page_cancelled', ['show_orders'=>$show_orders]);
    }

    //Hàm cập nhật số lượng sp trong giỏ hàng
    public function update_cart(Request $request,$id_user,$id_cart){
        //Lấy id_cart và id_user
        $get_cart_user = ShoppingCart::where([['id','=',$id_cart],['user_id','=',$id_user]])->first();
        //Lấy id cart vừa nhận
        $get_cart = $get_cart_user->id;
        //Lấy id sản phẩm sau đó lấy số lượng
        $get_product = Product::where('id',$get_cart_user->product_id)->first();
        $get_qty_pro = $get_product->product_quantity;
        //Lấy số lượng input request
        $get_qty = $request->input('quantity');
        if($get_qty > $get_qty_pro){
            return redirect()->back()->with('alert','Số lượng sản phẩm không đủ');
        }else{
            $update_cart = ShoppingCart::find($get_cart);
            $update_cart->quantity = $request->input('quantity');
            $update_cart->save();
            return redirect()->back();
        }
    }

    //Hàm thêm sản phẩm vào giỏ hàng
    public function add_cart($id_user,$id_product){
        //Tìm xem có tồn tại sản phẩm trong giỏ hàng chưa
        $get_cart = ShoppingCart::where([['product_id','=',$id_product],['user_id','=',$id_user]])->first();
        if(isset($get_cart)){
            $get_id = $get_cart->id;
            $update_cart = ShoppingCart::find($get_id);
            $update_cart->quantity = $update_cart->quantity + 1;
            $update_cart->save();
            return redirect()->back()->with('message','');
        }else {
            $add_cart = new ShoppingCart();
            $add_cart->user_id = $id_user;
            $add_cart->product_id = $id_product;
            $add_cart->quantity = 1;
            $add_cart->save();
            return redirect()->back()->with('message','');
        }
   }

   //Hàm xóa sản phẩm trong giỏ hàng
   public function delete_product_cart($id_cart){
       ShoppingCart::where('id',$id_cart)->delete();
       return redirect()->back()->with('cart','');
   }
   
   //Hàm thanh toán đơn hàng
   public function checkout_payment(Request $request, $id_user){
        //Thêm hóa đơn mới
        $add_order = new Order();
        $add_order->user_id = $id_user;
        $add_order->order_status = 0;
        $add_order->order_payment = 0;
        $add_order->save();
        //Lấy đơn hàng mới nhất
        $get_order_max = DB::table('orders')->max('id');
        //Lấy giỏ hàng của user 
        $get_carts = ShoppingCart::where('user_id',$id_user)->get();
        //Xử lí trong hóa đơn chi tiết
        foreach($get_carts as $get_cart){
            //Lấy id sản phẩm để truy xuất giá sp
            $get_prices = Product::where('id',$get_cart->product_id)->first();
            //Thêm vào Order-Details
            $add_detail = new OrderDetail();
            $add_detail->order_id = $get_order_max;
            $add_detail->product_id = $get_cart->product_id;
            $add_detail->total_quantity = $get_cart->quantity;
            $add_detail->total_price = ($get_cart->quantity * $get_prices->product_price);
            $add_detail->save();
            //Lấy số lượng giỏ hàng và sản phẩm
            $get_qty_cart = $get_cart->quantity;
            $get_qty = $get_prices->product_quantity;
            //Lấy số lượng sản phẩm trừ giỏ hàng
            if($get_prices->category_id == 1){
                foreach($get_prices as $get_price){
                    $quantity = ($get_qty - $get_qty_cart);
                    DB::table('products')->where('category_id',1)->update(['product_quantity'=> $quantity]);
                }
            }
            else{
                $quantity = ($get_prices->product_quantity - $get_qty_cart);
                //Cập nhật lại số lượng
                DB::table('products')->where('id',$get_cart->product_id)->update(['product_quantity'=> $quantity]);
            }
        }
        DB::table('shopping_carts')->where('user_id',$id_user)->delete();
        return redirect('page-wait-payment/'.$id_user)->with('alert','Đặt hàng thành công!!!');
   }

    //Trang thanh toán
    public function page_checkout($id_user){
        $show_carts = ShoppingCart::where('user_id',$id_user)->get();
        return view('home.page_checkout',['show_carts'=>$show_carts]);
    }

    //Trang menu
    public function page_category(){
        $show_cates = DB::table('categories')->get();
        return view('home.page_category',['show_cates' => $show_cates]);
    }

    //Thanh sản phẩm
    public function page_product($id_category, Request $request){
        // $category_id = Category::find($id_category);
        if($id_category == 0)
        {
            $search = $request->input('inputSearch');
            $show_products = DB::table('products')->where('product_name', 'like', '%'.$search.'%')->get();
        } else{
            $show_products = Product::where('category_id',$id_category)->latest()->get();
        }
        return view('home.page_product',
        [
            'id_category'=>$id_category,
            'show_products'=>$show_products
        ]);
    }

    public function page_product_detail($id){
        $get_product = DB::table('products')->where('id',$id)->first();
        return view('home.product_detail',['get_product' => $get_product]);
    }
    //Trang Table_Category
    public function page_table_category($id_table){
        $id = $id_table;
        $show_cates = DB::table('categories')->get();
        return view('home.order_table.page_table_category',[
            'show_cates' => $show_cates,
            'id'=>$id
        ]);
    }

    //Trang Table_Product
    public function page_table_product($id_category,$id_table){
        $id = $id_table;
        $category_id = Category::find($id_category);
        $show_products = Product::where('category_id',$id_category)->latest()->get();
        return view('home.order_table.page_table_product',
        [
            'id'=>$id,
            'category_id'=>$category_id,
            'show_products'=>$show_products
        ]);
    }
    public function facebookRedirect(){
        return Socialite::driver('facebook')->redirect();
    }
    public function googleRedirect(){
        return Socialite::driver('google')->redirect();
    }
    public function loginWithFacebook()
    {
        $user = Socialite::driver('facebook')->user();
        $check_exist = User::where('facebook_id',$user->getId())->first();
        if($check_exist == null){
            $saveUser = DB::table('users')->insert([
                'role_id' => 3,
                'user_name' => $user->getName(),
                'email' => $user->getEmail(),
                'facebook_id' => $user->getId(),
                'password' => Hash::make($user->getName().'@'.$user->getId())
            ]);
            Auth::loginUsingId($user->getId());
        }
        else{
            Auth::loginUsingId($check_exist->id);
        }
        return redirect('/')->with('message1','');
    }
    public function loginWithGoogle()
    {
        $user = Socialite::driver('google')->user();
        $check_exist = User::where('google_id',$user->getId())->first();
        if($check_exist == null){
            $saveUser = DB::table('users')->insert([
                'role_id' => 3,
                'user_name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
                'password' => Hash::make($user->getName().'@'.$user->getId())
            ]);
            // Auth::loginUsingId($saveUser->id);
            Auth::loginUsingId($user->getId());
        }
        else{
            Auth::loginUsingId($check_exist->id);
        }
        return redirect('/')->with('message1','');
    }
}
