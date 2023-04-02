@extends('layout.layout')
@section('title','Trang liên lạc')
@section('content')

<style>
    .my-form {
        color: #305896;
    }
    .my-form .btn-default {
        background-color: #305896;
        color: #fff;
        border-radius: 0;
    }
    .my-form .btn-default:hover {
        background-color: #4498C6;
        color: #fff;
    }
    .my-form .form-control {
        border-radius: 0;
    }
    .address-icon i{
        font-size: 36px;
        line-height: 32px;
    }
    .icons i{
        color: #fff;
        padding: 8px 0px;
        text-align: center;
        height: 30px;
        width: 30px;
        margin-right: 5px;
    }
</style>


<div class="container" style="margin-bottom: 20px;">
    <div class="row bg-light pt-3 pb-3 mb-4" style="background-color: #F4F4F4; margin: 30px 0px;">
        <div class="col-lg-12">
            <br><h4>LIÊN LẠC :</h4>
        </div>
        <div class="col-lg-4 col-4">
            <p>
                Vui lòng để lại thông tin tại đây, chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất!!!
            </p>
        </div>
        {{-- <img src="{{ url('public/home/upload_img/logo2.png') }}" width="300" height="80"> --}}
        <div class="col-lg-4 col-4">
            <p class="m-0 text-danger"><i class="fa fa-phone-square" aria-hidden="true"></i>
                (+84) 7116-196-984
            </p>
            <p class="m-0 text-info"><i class="fa fa-envelope" aria-hidden="true"></i>
                hurricane-fatsfood@gmail.com
            </p>
        </div>
        <div class="col-lg-4 col-4 address-icon text-center text-danger">
            <i class="fa fa-map-marker" aria-hidden="true"> Address</i><p>
                CMT8, Phường An Hòa, 
                Quận Ninh Kiều, Thành Phố Cần Thơ
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {{-- <div id="googlemap" style="width:100%; height:400px;"></div> --}}
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.575004515699!2d105.77109291474267!3d10.051885192815577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08806ff83096f%3A0xd87e495597f7ed8c!2zTG90dGVyaWEgQ8OhY2ggTeG6oW5nIFRow6FuZyA4!5e0!3m2!1svi!2s!4v1638429894094!5m2!1svi!2s" 
                width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <br />
        <div class="col-md-6" style="background-color: #F4F4F4; padding: 20px 10px;">
            <form class="my-form" action="{{ route('post.feedback') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="form-name">Họ Tên</label>
                    <input type="text" class="form-control" id="form-name" placeholder="Nhập họ và tên" name="inputName">
                </div>
                <div class="form-group">
                    <label for="form-email">Email</label>
                    <input type="email" class="form-control" id="form-email" placeholder="Nhập email" name="inputEmail">
                </div>
                <div class="form-group">
                    <label for="form-subject">Điện thoại</label>
                    <input type="text" class="form-control" id="form-subject" placeholder="Nhập số điện thoại" name="inputPhone">
                </div>
                <div class="form-group">
                    <label for="form-subject">Tiêu để</label>
                    <input type="text" class="form-control" id="form-subject" placeholder="Nhập tiêu để" name="inputTitle">
                </div>
                <div class="form-group">
                    <label for="form-message">Nội dung</label>
                    <textarea class="form-control" id="form-message" placeholder="Nhập nội dung phản hồi" name="inputText" rows="8"></textarea>
                </div>
                <button class="btn btn-danger float-right"  type="submit">Gửi</button>           
            </form>
        </div>
    </div>
</div>

{{-- <script src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        // Google Maps setup
        var googlemap = new google.maps.Map(
            document.getElementById('googlemap'),
            {
                center: new google.maps.LatLng(44.5403, -78.5463),
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );
    });
</script> --}}




@endsection