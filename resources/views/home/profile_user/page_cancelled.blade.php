@extends('home.profile_user.layout_profile')
@section('content-profile-col-9')

<div class="table-responsive-sm">
    <br>
    @forelse($show_orders as $key => $data)
        <div class="panel panel-default">
            <div class="panel-body" style="padding:1px 1px;">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Tên SP</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Tùy chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($get_details = DB::table('order_details')->where('order_id', $data->id)->get())

                    <?php $total_payment = 0; ?>

                    @foreach($get_details as $get_detail)
                        @if($get_detail->product_id != NULL)
                        @php($get_product = DB::table('products')->where('id', $get_detail->product_id)->first())
                            <tr>
                                <td data-label="STT">{{ ++$key }}</td>
                                <td data-label="Hình ảnh">
                                    <a href="#">
                                        <img class="shop_thumbnail" src="{{url('public/home/upload_img/'.$get_product->product_img)}}" width="50" height="50" >
                                    </a>
                                </td>
                                <td data-label="Tên SP">
                                    {{ $get_product->product_name }}
                                </td>
                                <td data-label="Giá">
                                {{ number_format($get_product->product_price )}} VND
                                </td>
                                <td data-label="Số lượng">
                                {{ $get_detail->total_quantity }}
                                </td>
                                <td data-label="Tổng tiền">
                                    <?php
                                        $price = $get_product->product_price;
                                        $qty = $get_detail->total_quantity;
                                        $total = $price* $qty;

                                        $total_payment = $total_payment + $total;
                                    ?>
                                    {{ number_format($total) }} VND
                                </td>
                                <td data-label="Mua Lại">
                                    <a class="btn btn-success" href="{{ url('page-product-detail/'.$get_detail->product_id) }}" role="button">
                                        <i class="fa fa-repeat"></i> Mua Lại
                                    </a>
                                </td>
                            </tr>
                        @else
                        @php($get_combo = DB::table('combos')->where('id', $get_detail->combo_id)->first())
                        <tr>
                            <td data-label="STT">{{ ++$key }}</td>
                            <td data-label="Hình ảnh">
                                <a href="#">
                                    <img class="shop_thumbnail" src="{{url('public/home/upload_img/'.$get_combo->combo_img)}}" width="50" height="50" >
                                </a>
                            </td>
                            <td data-label="Tên SP">
                                {{ $get_combo->combo_name }}
                            </td>
                            <td data-label="Giá">
                            {{ number_format($get_combo->combo_total_price )}} VND
                            </td>
                            <td data-label="Số lượng">
                            {{ $get_detail->total_quantity }}
                            </td>
                            <td data-label="Tổng tiền">
                                <?php
                                    $price = $get_combo->combo_total_price;
                                    $qty = $get_detail->total_quantity;
                                    $total = $price* $qty;

                                    $total_payment = $total_payment + $total;
                                ?>
                                {{ number_format($total) }} VND
                            </td>
                            <td data-label="Mua Lại">
                                <a class="btn btn-success" href="{{ url('page-product-detail/'.$get_detail->combo_id) }}" role="button">
                                    <i class="fa fa-repeat"></i> Mua Lại
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="5">
                           <b>Tổng thanh toán:</b> 
                        </td>
                        <td colspan="1">
                            {{ number_format($total_payment) }} VND
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-danger text-center" role="alert">
            <strong style="font-size: 25px;">Bạn chưa có đơn hàng nào đã đặt!</strong>
        </div>
    @endforelse
    <ul class="pagination justify-content-xl-end" style="margin:20px 0">
        {{ $show_orders->links() }}
    </ul>
</div>

@endsection
