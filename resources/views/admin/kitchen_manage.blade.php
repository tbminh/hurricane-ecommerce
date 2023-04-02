<!DOCTYPE html>
<html>
<head>
	<title>Trang quản lý bếp</title>
    <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ url('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{url('public/plugins/jqvmap/jqvmap.min.css ')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('public/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('public/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/home/css/table.css') }}" type="text/css">

    {{-- Sweet Alert --}}
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../public/js/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
	
</head>
<style>
    table thead	 tr th{
		text-align: center;	
		}
    table tbody tr td{
        text-align: center;
    }
</style>
<div class="header-cashier" style="background-color: #e74c3c;">
    <div class="container-fluid">
        <div class="row ft-tabs">
            <div class="col-md-3">
                <div style="padding-left: 15px;">
                    <a href="{{ url('logout') }}"  target="_blank"  class="navbar-brand" >
                        <img src="{{ url('public/home/upload_img/logo-brand.png') }}" style="max-width: 50%; height:60px;">
                        <span class="brand-text font-weight-light" style="color:white; font-size:23px; ">
                            URRICANE 
                        </span><br>
                        <span class="brand-text font-weight-light" style="color:white; font-size:18px;">
                            Thà nịn nói chứ không nhịn đói!
                        </span>
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                <div style="margin-top: 25px;">
                    <marquee scrollamount="10">
                        <span class="brand-text font-weight-light" style="color:white; font-size:25px;">
                            🔥🔥🔥 Cố hết sức mình đi, tôi biết bạn sẽ thực hiện được. 
                            Đây là toàn cầu của hành động và thử thách, không phải toàn cầu của sự lười biếng và hèn nhát. 👍👍👍
                        </span>
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</div>

	<div class="container-fluid">
		<div class="row content">
			<div class="col-md-5" id="table-list">
                <div class="row list-filter">
                    <div class="col-md list-filter-content" style="margin-left: 40px;">
                        <button class="btn btn-primary" type="button" > Bàn đang đợi món</button>
                    </div>
                </div>
                <div class="row table-list">
                    <div class="col-md table-list-content">
                        <ul>
                            <?php $name ="";?>
                            @foreach($show_tables as $show_table)
                                @if ($show_table->table_status == 1)
                                    @if ($show_table->pairing_table != NULL)
                                        @if ($show_table->pairing_table != $name)
                                            @php($get_cart = DB::table('table_carts')->where('pairing',$show_table->pairing_table)->first())
                                            @if ($get_cart->table_id == $id_table)
                                                <li style="background-color: #d63031;">
                                            @else
                                                <li style="background-color: #e67e22;">
                                            @endif
                                                <a href="{{ url('kitchen-manage/'.$get_cart->table_id) }}" style="color: #fff;"
                                                    title="Nhấp để chọn món">
                                                    {{ $show_table->pairing_table }}
                                                </a>
                                            </li>
                                            <?php $name = $show_table->pairing_table; ?>
                                        @endif
                                    @else
                                        @if ($show_table->id == $id_table)
                                            <li style="background-color: #d63031;" id="table{{ $show_table->id }}">
                                        @else
                                            <li style="background-color: #e67e22;" id="table{{ $show_table->id }}">
                                        @endif
                                            <a href="{{ url('kitchen-manage/'.$show_table->id) }}" style="color: #fff;">
                                                {{ $show_table->table_name }}
                                            </a>
                                        </li>
                                    @endif
                                @elseif ($show_table->table_status == 2)
                                    @if ($show_table->pairing_table != NULL) 
                                        @if ($show_table->pairing_table != $name)
                                            @php($get_cart = DB::table('table_carts')->where('pairing',$show_table->pairing_table)->first())
                                            @if ($get_cart->table_id == $id_table)
                                                <li style="background-color: #d63031;" id="table{{ $show_table->id }}">
                                            @else
                                                <li style="background-color: #44bd32;" id="table{{ $show_table->id }}">
                                            @endif
                                                <a href="{{ url('kitchen-manage/'.$get_cart->table_id) }}" style="color: #fff;"
                                                    title="Nhấp để chọn món">
                                                    {{ $show_table->pairing_table }}
                                                </a>
                                            </li>
                                            <?php $name = $show_table->pairing_table; ?>
                                        @endif
                                    @else
                                        @if ($show_table->id == $id_table)
                                            <li style="background-color: #d63031;" id="table{{ $show_table->id }}">
                                        @else
                                            <li style="background-color: #44bd32;" id="table{{ $show_table->id }}">
                                        @endif
                                            <a href="{{ url('kitchen-manage/'.$show_table->id) }}" style="color: #fff;">
                                                {{ $show_table->table_name }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach   
                        </ul>
                    </div>
                </div>
                <div style="margin-top: 200px;"></div>
                <div class="row table-list">
                    <div class="col-md table-list-content">
                        <ul>	
                            <li style="background-color: #e67e22; height: 35px; width: 35px;"></li>
                            <span>Bàn chưa giao đủ món</span><br><br>
                            <li style="background-color: #44bd32; height: 35px; width: 35px;"></li>
                            <span>Bàn đã giao đủ món</span><br><br>
                            <li style="background-color: #d63031; height: 35px; width: 35px;"></li>
                            <span>Bàn đang chọn</span>
                        </ul>
                    </div>
                </div>
            </div>
			<div class="col-md-7 content-listmenu" id="content-listmenu">
				<div class="row" id="bill-info">
				</div>
				<div class="row bill-detail">
					<div class="col-md-12 bill-detail-content">
						<table class="table table-bordered">
						  <thead class="thead-light">
						    <tr>
                                @php($get_name = DB::table('tables')->where('id',$id_table)->first()) 
                                <th scope="col">STT</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">SL làm xong</th>
                                <th scope="col">Trạng Thái</th>
						    </tr>
						  </thead>
						  <tbody id="pro_search_append">
                            @if($id_table != 0)
                                @php($show_carts = DB::table('table_carts')->where('table_id',$id_table)->get())
                                @foreach ($show_carts as $key => $show_cart)
                                @php($get_products = DB::table('products')->where('id',$show_cart->product_id )->first())
                                <tr>
                                    <td> {{ ++$key }} </td>
                                    {{-- Hiển thị sản phẩm trong table cart --}}
                                    @if ($get_products != NULL)
                                        <td data-label="Tên sản phẩm">
                                            <span>{{ $get_products->product_name }}</span>
                                        </td>
                                        <td>
                                            <img src="{{ asset('public/home/upload_img/'.$get_products->product_img) }}" class="img-circle elevation-2" width="40px" height="40px">
                                        </td>
                                        <td data-label="Số lượng" id="tc_qty"> 
                                            <span>{{ $show_cart->tc_quantity }}</span>
                                        </td>
                                        <td>
                                            <input type="number" style="width: 50px; text-align: center;" 
                                            class="quantity-product-oders" value="{{ $show_cart->kitchen_qty_complete }}" id="qty_kitchen{{ $show_cart->id }}"
                                            onchange="myFunction({{ $show_cart->id }} + ',' + this.value + ',' + {{ $show_cart->tc_quantity }} + ',' + {{ $show_cart->kitchen_qty_complete }})">
                                        </td>
                                        <td id="kitchen-check{{ $show_cart->id }}">
                                            @if($show_cart->kitchen_qty_complete < $show_cart->tc_quantity)
                                                <button role="button" class="btn btn-outline-warning">
                                                    <i class="fa fa-check"></i> Đang làm
                                                </button>
                                            @else
                                                <button role="button"  class="btn btn-outline-success" >
                                                    <i class="fa fa-check"></i> Đã xong
                                                </button>
                                            @endif
                                        </td>
                                    {{-- Hiển thị danh sách combo trong table cart --}}
                                    @else
                                        @php($get_combos = DB::table('combos')->where('id',$show_cart->combo_id)->first())
                                        <td data-label="Tên combo">
                                            <span>{{ $get_combos->combo_name }}</span>
                                        </td>
                                        <td>
                                            <img src="{{ asset('public/home/upload_img/'.$get_combos->combo_img) }}" class="img-circle elevation-2" width="40px" height="40px">
                                        </td>
                                        <td data-label="Số lượng"> 
                                            <span>{{ $show_cart->tc_quantity }}</span>
                                        </td>
                                        <td>
                                            <input type="number" style="width: 50px; text-align: center;" 
                                            class="quantity-product-oders" value="{{ $show_cart->kitchen_qty_complete }}" id="qty_kitchen{{ $show_cart->id }}"
                                            onchange="myFunction({{ $show_cart->id }} + ',' + this.value + {{ $show_cart->tc_quantity }} + ',' + {{ $show_cart->kitchen_qty_complete }}+ ',' )">
                                        </td>
                                        <td id="kitchen-check{{ $show_cart->id }}">
                                            @if($show_cart->kitchen_qty_complete < $show_cart->tc_quantity)
                                                <button role="button" class="btn btn-outline-warning">
                                                    <i class="fa fa-check"></i> Đang làm
                                                </button>
                                            @else
                                                <button role="button"  class="btn btn-outline-success" >
                                                    <i class="fa fa-check"></i> Đã xong
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
						  </tbody>
						</table>
					</div>
				</div>
				<div class="row bill-action">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-8 p-1">
								<textarea class="form-control" id="note-order" placeholder="Nhập ghi chú món ăn" rows="2"></textarea>
							</div>
                            <div class="col-md-4 p-1">
                                <a type="button" href="{{ url('kitchen-manage/0') }}" class="btn-pay" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Cập Nhật</a>
                            </div>
						</div>
 					</div>
 					
				</div>
			</div>
		</div>
	</div>

    <script>
        //Lấy id giỏ hàng và số lượng sp làm xong
        function myFunction(e) {
            var ele = e.split(",");
            if(ele[1] > ele[2]){
                alert('Vượt quá số lượng khách đặt!!!');    
                $("#qty_kitchen"+ele[0]).val(ele[3]);
            } else{
                update_kitchen_qty(ele[0],ele[1]);
            }
	    }

        //Hàm cập nhật số lượng
        function update_kitchen_qty(key,qty){
            $.ajax({
                url: "{{ url('update-kitchen-quantity') }}/"+key+"/"+qty,
                type: 'GET',
                success:function(response){
                    var tc_qty = response['tc_qty'];
                    var kitchen_qty = response['kitchen_qty'];

                    if(tc_qty > qty){
                        $("#kitchen-check"+key).empty().append("<button role='button' class='btn btn-outline-warning'><i class='fa fa-check'></i> Đang làm</button>");
                    }else {
                        $("#kitchen-check"+key).empty().append("<button role='button' class='btn btn-outline-success'><i class='fa fa-check'></i> Đã xong</button>");  
                    } 
                }
            })
        }
    </script>