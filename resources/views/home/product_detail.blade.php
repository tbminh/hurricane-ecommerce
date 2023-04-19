@extends('layout.layout')
@section('title','Chi tiết sản phẩm')
@section('content')

<style>
    .main{
        display: block;
    }
    .detail {
        padding-top: 30px;
        min-height: 300px;
        padding-bottom: 30px;
    }
    .product-category-detail {
        margin-bottom: 60px;
        display: block;
        zoom: 1;
        margin-left: 300px;
    }
    .product-category-detail .field-img{
        background: url('https://www.lotteria.vn/grs-static/images/bg-4.png') no-repeat 0 0;
        width: 450px;
        float: left;
        margin-right: 70px;
        padding: 22px 0 0 57px;
        position: relative;
        min-height: 100px;
    }
    
    .product-category-detail .field-content{
        overflow: hidden;
    }
    .product-category-detail h3{
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 16px;
    }
    .product-category-detail .field-price{
        color: #d50000;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 14px;
    }
    .product-category-detail .field-note{
        border-top: 1px dashed #c4c4c4;
        margin-bottom: 18px;
        padding-top: 16px;
    }

    .product-category-detail .quantity{
        margin-bottom: 20px;
        width: 100%;
        display: block;
        zoom: 1;
    }
    .product-category-detail .quantity .lbl{
        float: left;
        margin-right: 10px;
        padding-top: 5px;
    }
    .product-category-detail .quantity .inner{
        width: 150px;
        float: left;
    }
    .quantity .inner{
        border-radius: 4px;
        position: relative;
        border: 1px solid #e1e1e1;
        padding: 0 30px;
        height: 30px;
    }
    .quantity .inner button {
        border: 0;
        width: 30px;
        height: 29px;
        cursor: pointer;
        background: #e1e1e1;
        text-align: center;
        color: #0e0e0e;
        font-weight: 400;
        position: absolute;
        top: 0;
        z-index: 1;
        left: 0;
    }
    .quantity .inner input {
        width: 100%;
        text-align: center;
        padding: 3px 2px 2px;
        border: 0;
        background: 0;
        height: 28px;
    }
    .quantity .inner button.btn-plus{
        left: auto;
        right: 0;
    }
    .product-category-detail .btn-cart {
        padding-left: 35px;
        padding-right: 35px;
        font-weight: 700;
        margin-left: 520px;
    }
    .btn-secondary {
        background-color: #ffd800;
        border-color: #ffd800;
        color: #0e0e0e;
    }
    .related-product{
        margin-left: 300px;
    }
    .head-title {
        font-size: 23px;
        font-weight: 700;
    }
    .head-title span:before {
        content: '';
        width: 60px;
        height: 2px;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 1;
        background-color: #d50000;
    }
    .head-title span {
        display: inline-block;
        position: relative;
        padding-top: 6px;
    }
    .product-list .items {
        margin-left: -8px;
        margin-right: -8px;
        display: flex;
        flex-wrap: wrap;
        padding: 0;
    }
    .product-list .owl-carousel {
        margin: 0;
    }
    .owl-carousel.owl-loaded {
        display: block;
    }
    .owl-carousel{
        width: 100%;
        z-index: 1;
    }
    .owl-carousel .owl-stage-outer {
        position: relative;
        overflow: hidden;
        -webkit-transform: translate3d(0,0,0);
    }
    .owl-carousel .owl-stage {
        position: relative;
    }
    .product-list .owl-carousel li {
        display: block;
        width: auto;
        margin-bottom: 0;
        padding: 5px;
        list-style: none;
    }
    .product-list .content {
        background: #fff;
        padding: 15px;
        text-align: center;
        width: 100%;
    }
    .product-list .content:hover{
        background-color: rgba(255, 255, 255, 0.219);
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        box-shadow: 0 1px 2px rgba(0,0,0,.2);
    }
    .product-list .content .field-img {
        margin-bottom: 10px;
        position: relative;
    }
    .product-list .content h3 {
        text-transform: none;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 7px;
        height: 37px;
        overflow: hidden;   
    }
    .product-list .content .field-price {
        font-size: 24px;
        color: #d50000;
        margin-bottom: 15px;
        font-weight: 700;
    }
</style>

<form action="{{ url('add-cart-detail/'.$get_product->id.'/'.Auth::id()) }} " method="POST">
    @csrf
    <main>
        <div class="detail">
            <div class="product-category-detail">
                <div class="field-img">
                    <div class="item">
                        <img src="{{ asset('public/home/upload_img/'.$get_product->product_img) }}" width="300">
                    </div>
                </div>
                <div class="field-content">
                    <h3>{{ $get_product->product_name }}</h3>
                    <div class="field-price">
                        <span>{{ number_format($get_product->product_price) }} đ/{{ $get_product->unit_price }}</span>
                    </div>
                    <div class="field-note">
                        @php($get_pro_sup = DB::table('product_suppliers')->where('product_id',$get_product->id)->first())
                        @php($get_sup = DB::table('suppliers')->where('id',$get_pro_sup->supplier_id)->first())
                        
                        Nhà Cung Cấp: <img src="{{ asset('public/home/upload_img/'.$get_sup->supplier_img) }}" width="50" height="50"> 
                        {{ $get_sup->supplier_name }}
                    </div>
                    <div class="quantity">
                        <div class="lbl">
                            Số Lượng
                        </div>
                        <div class="inner">
                            <button class="btn-minute" type="button">-</button>
                            <input type="number" value="1" name="inputQty">
                            <button class="btn-plus" type="button">+</button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary btn-cart" type="submit" title="Thêm vào giỏ hàng">
                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                </button>
            </div>
            <div class="related-product">
                <h2 class="head-title">
                    <span>Sản phẩm liên quan</span>
                </h2>
                <div class="product-list">
                    <ul class="items">
                        <div class="owl-carousel owl-theme owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage d-flex" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2280px;">
                                    @if (isset($get_combo))
                                        @php($relate_item = DB::table('combos')->latest()->take(3)->get())
                                        @foreach ($relate_item as $item)
                                            <div class="owl-item active" style="width: 366px; margin-right: 14px;">
                                                <li>
                                                    <div class="content">
                                                        <div class="field-img">
                                                            <a href="#">
                                                                <img src="{{  asset('public/home/upload_img/'.$item->combo_img) }}" alt="" >
                                                            </a>
                                                        </div>
                                                        <a href="#"><h4>{{ $item->combo_name }}</h4></a>
                                                        <div class="field-price">{{ number_format($item->combo_total_price) }} đ/Combo</div>
                                                        <div class="field-btn">
                                                            @if(Auth::check())
                                                                <a class="btn btn-secondary btn-cart" 
                                                                href="{{ url('add-combo-cart/'.Auth::id().'/'.$item->id) }}" title="Thêm vào giỏ hàng">
                                                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                                                </a>
                                                            @else
                                                                <a class="btn btn-secondary btn-cart" onclick="return confirm('Bạn cần đăng nhập trước!')"
                                                                type="button"  data-toggle="modal" data-target="#exampleModalSignIn" title="Thêm vào giỏ hàng">
                                                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        @endforeach
                                    @else
                                        @php($get_cate = DB::table('categories')->where('id',$get_product->category_id)->first())
                                        @php($relate_item = DB::table('products')->where('category_id',$get_cate->id)->latest()->take(3)->get())
                                        @foreach ($relate_item as $item)
                                            <div class="owl-item active" style="width: 366px; margin-right: 14px;">
                                                <li>
                                                    <div class="content">
                                                        <div class="field-img">
                                                            <a href="{{ url('page-product-detail/'.$item->id) }}">
                                                                <img src="{{  asset('public/home/upload_img/'.$item->product_img) }}" width="236" height="165" >
                                                            </a>
                                                        </div>
                                                        <a href="{{ url('page-product-detail/'.$item->id) }}"><h4>{{ $item->product_name }}</h4></a>
                                                        <div class="field-price">{{ number_format($item->product_price) }} đ/{{ $item->unit_price }}</div>
                                                        <div class="field-btn">
                                                            @if(Auth::check())
                                                                <a class="btn btn-secondary btn-cart" 
                                                                href="{{ url('add-combo-cart/'.Auth::id().'/'.$item->id) }}" title="Thêm vào giỏ hàng">
                                                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                                                </a>
                                                            @else
                                                                <a class="btn btn-secondary btn-cart" onclick="return confirm('Bạn cần đăng nhập trước!')"
                                                                type="button"  data-toggle="modal" data-target="#exampleModalSignIn" title="Thêm vào giỏ hàng">
                                                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</form>
@if(session()->has('message'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Đã thêm vào giỏ hàng!',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
@endif
@endsection