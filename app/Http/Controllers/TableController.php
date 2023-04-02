<?php

namespace App\Http\Controllers;

use App\Combo;
use App\ComboProduct;
use App\OrderTable;
use App\OtDetail;
use App\Product;
use App\Table;
use App\TableCart;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class TableController extends Controller
{
    //Trang chọn bàn
    public function table_manage($id_area){
        $show_areas = DB::table('table_area')->get();
        if($id_area == 0){
            $show_tables = DB::table('tables')->paginate(12);
        } else{
            $show_tables = DB::table('tables')->where('area_id',$id_area)->paginate(12);
        }
        return view('order_table.table',[
            'show_areas'=> $show_areas,
            'show_tables' => $show_tables
        ]);
    }

    //Trang chọn món
    public function table_menu($id_table,$id_cate){
        $show_cates = DB::table('categories')->get();
        if($id_cate == 0){
            $show_products = DB::table('products')->inRandomOrder()->paginate(8);
        } else{
            $show_products = DB::table('products')->where('category_id',$id_cate)->latest()->paginate(8);
        }
        return view('order_table.table_menu',[
            'id_table' => $id_table,
            'show_cates' => $show_cates,
            'show_products' => $show_products,
            'id_cate'=>$id_cate
        ]);
    }

    //Hàm thêm sp vào table-cart
    public function add_table_cart($id_user,$id_table,$id_product){
        $check_cart = DB::table('table_carts')->where([['table_id', $id_table], ['product_id', $id_product]])->first();
        if(isset($check_cart)){
            $get_id = $check_cart->id;
            $update_cart = TableCart::find($get_id);
            $update_cart->tc_quantity = $update_cart->tc_quantity + 1;
            $get_pro = DB::table('products')->where('id',$id_product)->first();
            $update_cart->tc_total = $update_cart->tc_quantity * $get_pro->product_price;
            $update_cart->save();
        } else{
            $check_pair = DB::table('tables')->where('id',$id_table)->first();
            $add_cart = new TableCart();
            $add_cart->user_id = $id_user;
            $add_cart->table_id = $id_table;
            $add_cart->product_id  = $id_product;
            $add_cart->tc_quantity = 1;
            $get_pro = DB::table('products')->where('id',$id_product)->first();
            $add_cart->tc_total = $get_pro->product_price; 
            $add_cart->kitchen_qty_complete = 0;
            if($check_pair->pairing_table != NULL){
                $add_cart->pairing = $check_pair->pairing_table;
            }
            $add_cart->save();
        }
        DB::table('tables')->where('id',$id_table)->update(['table_status'=>1]);
        return redirect()->back();
    }

    //hàm thêm combo vào table-cart
    public function add_combo_tbcart($id_user,$id_table,$id_combo){
        $check_cart = TableCart::where([['table_id', $id_table], ['combo_id', $id_combo]])->first();
        if(isset($check_cart)){
            $get_id = $check_cart->id;
            $update_cart = TableCart::find($get_id);
            $update_cart->tc_quantity = $update_cart->tc_quantity + 1;
            $get_combo = DB::table('combos')->where('id',$id_combo)->first();
            $update_cart->tc_total = $update_cart->tc_quantity * $get_combo->combo_total_price;
            $update_cart->save();
        } else{
            $check_pair = DB::table('tables')->where('id',$id_table)->first();
            $add_cart = new TableCart();
            $add_cart->user_id = $id_user;
            $add_cart->table_id = $id_table;
            $add_cart->combo_id  = $id_combo;
            $add_cart->tc_quantity = 1;
            $get_combo = DB::table('combos')->where('id',$id_combo)->first();
            $add_cart->tc_total = $get_combo->combo_total_price;
            $add_cart->kitchen_qty_complete = 0;
            if($check_pair->pairing_table != NULL){
                $add_cart->pairing = $check_pair->pairing_table;
            }
            $add_cart->save();
            DB::table('tables')->where('id',$id_table)->update(['table_status'=>1]);
        }
        return redirect()->back();
    }

    //Hàm thanh toán cho table
    public function checkout_table(Request $request, $id_table){
        $get_table = Table::where('id',$id_table)->first();
        $add_ot = new OrderTable();
        if($get_table->pairing_table != NULL){
            $add_ot->ot_table = $id_table;
            //Lấy id của table_cart
            $get_table_carts = DB::table('table_carts')->where('pairing',$get_table->pairing_table)->get();
        } else{
            $add_ot->ot_table = $id_table;
            //Lấy id của table_cart
            $get_table_carts = DB::table('table_carts')->where('table_id',$id_table)->get();
        }
        $add_ot->ot_payment	= 1;
        $add_ot->ot_describe = $request->input('inputDes');
        $add_ot->save();
        //Lấy order_table vừa mới tạo
        $get_max_ot = DB::table('order_tables')->max('id');
        //Thêm chi tiết ot_detail
        foreach($get_table_carts as $get_table_cart){
            $add_detail = new OtDetail();
            $add_detail->ot_id = $get_max_ot;
            //Trường hợp giỏ hàng là sản phẩm
            if($get_table_cart->product_id != NULL){
                $add_detail->product_id = $get_table_cart->product_id;
                //Lấy id sp để truy xuất giá gốc và số lượng
                $get_product = DB::table('products')->where('id',$get_table_cart->product_id)->first();
                //Tính được tổng tiền từng món =  sp * sl 
                $add_detail->ot_price = $get_product->product_price * $get_table_cart->tc_quantity;
                $add_detail->ot_quantity = $get_table_cart->tc_quantity;
                $add_detail->save();
                //Lấy số lượng sp trong kho và sp từ giỏ hàng
                $get_qty = $get_product->product_quantity;
                $get_qty_cart = $get_table_cart->tc_quantity;
                //Trường hợp đặc biệt món gà rán
                if($get_product->category_id == 1){
                    $quantity = ($get_qty - $get_qty_cart);
                    DB::table('products')->where('category_id',1)->update(['product_quantity'=> $quantity]);
                
                } else{
                    //Trừ số lượng sp trong kho ra
                    $result =  $get_qty - $get_qty_cart;
                    DB::table('products')->where('id',$get_table_cart->product_id)->update(['product_quantity'=> $result]);
                }
            }
            //Trường hợp giỏ hàng là combo
            else{
                $add_detail->combo_id = $get_table_cart->combo_id;
                //Lấy id sp để truy xuất giá gốc và số lượng
                $get_combo = DB::table('combos')->where('id',$get_table_cart->combo_id)->first();
                //Tính được tổng tiền theo
                $add_detail->ot_quantity = $get_table_cart->tc_quantity;
                $add_detail->ot_price = $get_combo->combo_total_price * $get_table_cart->tc_quantity;
                $add_detail->save();
                //Trừ số lượng sản phẩm trong kho theo combo
                $get_combo_product = ComboProduct::where('combo_id',$get_combo->id)->get();
                foreach($get_combo_product as $data){
                    $get_pro = Product::where('id',$data->product_id)->first();
                    $quantity = $get_pro->product_quantity - $data->quantity_combo;
                    if($get_pro->category_id == 1){
                        DB::table('products')->where('category_id',1)->update(['product_quantity'=> $quantity]);
                    } else{
                        $get_pro->product_quantity = $quantity;
                    }
                    
                    $get_pro->save();
                }
            }
        }
        if($get_table->pairing_table != NULL){
            DB::table('table_carts')->where('pairing',$get_table->pairing_table)->delete();
            DB::table('tables')->where('pairing_table',$get_table->pairing_table)->update(['table_status'=>0,'pairing_table'=>NULL]);
        } else{
            DB::table('table_carts')->where('table_id',$id_table)->delete();
            DB::table('tables')->where('id',$id_table)->update(['table_status'=>0]);
        }
        return redirect('table-manage/0')->with('success','Đã thanh toán');
    }

    //Hàm xóa table cart
    public function delete_table_cart($id_table){
        $get_cart = DB::table('table_carts')->where('table_id',$id_table)->first();
        $get_table = Table::where('id',$id_table)->first();
        if(isset($get_cart)){
            if($get_cart->pairing != NULL){     //Xóa bàn ghép
                TableCart::where('pairing',$get_cart->pairing)->delete();
                DB::table('tables')->where('pairing_table',$get_cart->pairing)->update(['table_status'=>0,'pairing_table'=>NULL]);
            } else{
                TableCart::where('table_id',$id_table)->delete();
                DB::table('tables')->where('id',$id_table)->update(['table_status'=>0,'pairing_table'=>NULL]);
            }
        }else if($get_table->pairing_table != NULL){ // Trường hợp chưa thêm sp vào table nhưng là bàn ghép
            DB::table('tables')->where('pairing_table',$get_table->pairing_table)->update(['table_status'=>0,'pairing_table'=>NULL]);
        }  
        return redirect('table-manage/0')->with('delete','Đã xóa bàn');
    }

    //Hàm xóa table cart
    public function delete_product_tc($key){
        $delete_cart = TableCart::find($key);
        $get_id = $delete_cart->table_id;
        $delete_cart->delete();
        //tính lại tổng giá
        $total = 0;
        $get_carts = TableCart::where('table_id',$get_id)->get();
        foreach($get_carts as $get_cart){
            $total = $total + $get_cart->tc_total;
        }
        return response()->json($total);
    }
    
    //Cập nhật số lượng table-cart
    public function update_cart($key, $qty){
        $add_cart = TableCart::where('id',$key)->first();
        $add_cart->tc_quantity = $qty;
        if($add_cart->product_id != NULL){
            $get_pro = Product::where('id',$add_cart->product_id)->first();
            $add_cart->tc_total = $get_pro->product_price * $qty;
        } else{
            $get_combo = Combo::where('id',$add_cart->combo_id)->first();
            $add_cart->tc_total = $get_combo->combo_total_price * $qty;
        }
        
        $add_cart->save();
        //Tính tổng giá
        $total = 0;
        $get_carts = TableCart::where('table_id',$add_cart->table_id)->get();
        foreach($get_carts as $get_cart){
            $total = $total + $get_cart->tc_total;
        }
        $result = [
            'tc_total' => $add_cart->tc_total,
            'total' => $total
        ];
        return response()->json($result);
    }

    //Hàm tìm kiếm product trong table menu
    public function search_pro_table($key){
        $get_products = Product::select('product_name','id')->where('product_name','like','%'.$key.'%')->get();
        $result = [];
        if(!isset($get_products)){
            $result = "<li>Không có kết quả nào</li>";
        }else{
            foreach($get_products as $key => $data){
                // $result[] = array(
                //     "name"=> $data->product_name,
                //     "img"=>$data->product_img
                // );
                $result[] = $data->product_name;
            }
        }
        // return response()->json($result);
        return response()->json($result, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }

    public function kitchen_manage($id_table){
        $show_tables = DB::table('tables')->get();
        $get_carts = DB::table('table_carts')->where('table_id',$id_table)->get();
        return view('admin.kitchen_manage',[
            'show_tables' => $show_tables,
            'id_table' => $id_table
        ]);
    }

    public function update_kitchen_quantity($key,$qty){
        $update_cart = TableCart::where('id',$key)->first();
        $get_table = Table::where('id',$update_cart->table_id)->first();
        $update_cart->kitchen_qty_complete = $qty;
        $update_cart->save();
        //Xét số lượng món ăn của table
        $get_carts = TableCart::where('table_id',$update_cart->table_id)->get();
        foreach($get_carts as $data){
            if($data->tc_quantity != $data->kitchen_qty_complete){
                $check = 0;
                break;
            }    
            else $check = 1;
        }
        if($check == 1){
            if($get_table->pairing_table == NULL){
                DB::table('tables')->where('id',$update_cart->table_id)->update(['table_status'=>2]);
            } else{
                DB::table('tables')->where('pairing_table',$get_table->pairing_table)->update(['table_status'=>2]);
            }
        } 
        else{
            if($get_table->pairing_table == NULL){
                DB::table('tables')->where('id',$update_cart->table_id)->update(['table_status'=>1]);
            } else{
                DB::table('tables')->where('pairing_table',$get_table->pairing_table)->update(['table_status'=>1]);
            }
        }
        $result = [
            'tc_qty' => $update_cart->tc_quantity,
            'kitchen_qty' => $update_cart->kitchen_qty_complete
        ];
        return response()->json($result);
    }

    //========HÀM TÌM KIẾM SẢN PHẨM AJAX=======//
    public function findTableName(Request $request){
        $data = Table::select('table_name','id','pairing_table')->where('area_id',$request->id)->get();
        return response()->json($data);
    }

    //Hàm đổi bàn
    public function change_table(Request $request, $id_table){
        $table_change_id = $request->input('inputTable');
        $update_carts = TableCart::where('table_id',$id_table)->get();
        foreach($update_carts as $data){
            $data->table_id = $table_change_id;
            $data->save();
        }
        DB::table('tables')->where('id',$id_table)->update(['table_status'=>0]);
        DB::table('tables')->where('id',$table_change_id)->update(['table_status'=>1]);
        return redirect('table-manage/0')->with('change_table','Đổi bàn thành công!');
    }

    //Hàm ghép bàn
    public function pairing_table(Request $request){
        $get_id_tables = $request->input('inputTable');
        // $rand_color = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT); //Hàm tự sinh mã màu
        $string_pairing = "";
        //Sinh ra chuỗi của bàn
        foreach($get_id_tables as $key => $data){
            $get_table = Table::where('id',$data)->first();
            $check_cart = TableCart::where('table_id',$data)->first();
            if($get_table->pairing_table != NULL){ //Nếu đã là bàn ghép thì trả tất cả về status chưa đặt
                DB::table('tables')->where('pairing_table',$get_table->pairing_table)->update(['pairing_table'=>NULL,'table_status'=>0]);
            }
            $string_pairing = $string_pairing.' '.$get_table->table_name;
        }
        //Gán chuỗi bàn vào
        foreach($get_id_tables as $key => $data){
            DB::table('tables')->where('id',$data)->update(['pairing_table'=>$string_pairing,'table_status'=>1]);
            //Nếu bàn này đã tồn tại trong giỏ hàng thì ghép giỏ hàng 
            $get_cart = TableCart::where('table_id',$data)->first();
            if(isset($get_cart)){
                DB::table('table_carts')->where('table_id',$data)->update(['pairing'=> $string_pairing]);
            } 
        }
        return redirect()->back()->with('pairing_success','Ghép bàn thành công');
    }
}
