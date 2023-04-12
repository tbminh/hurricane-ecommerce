@extends('layout.layout')
@section('title','Trang thực đơn')
@section('content')
<style>
   .products_2 img {
        width: 330px;
        height: 284px;
   }
</style>
<div class="collection_text">
    MENU
</div>

<section id="products">
    <div class="container">
        <div class="row products_main clearfix">
            @foreach($show_cates as $show_cate)
                <div class="col-sm-4">
                    <div class="products_2">
                        <a href="{{ url('page-product/'.$show_cate->id) }}">
                            <img src="{{ url('public/home/upload_img/'.$show_cate->category_image) }} " title="{{ $show_cate->category_name }}" class="img_responsive">
                        </a>
                        <p><a href="{{ url('page-product/'.$show_cate->id) }}">
                            {{ $show_cate->category_name }}
                        </a></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection