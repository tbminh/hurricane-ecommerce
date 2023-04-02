<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
	
    {{-- Bootstrap 4 --}}
	<link href="{{ asset('public/home/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('public/home/js/bootstrap.min.js') }}"></script>
	{{-- Jquery --}}
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="{{ asset('public/home/css/global.css') }}" rel="stylesheet">
	<link href="{{ asset('public/home/css/index.css') }}" rel="stylesheet">
	<link href="{{ asset('public/home/css/products.css') }}" rel="stylesheet">
	{{-- Font Style --}}
	<link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/home/css/font-awesome.min.css') }}" />

    <link href="{{ asset('public/home/css/animate.css') }}" rel="stylesheet" type="text/css" media="all">
    {{-- <script src="{{ asset('public/home/js/jquery-2.1.1.min.js') }}"></script> --}}

	@yield('link_css')
	{{-- Font AweSome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
	{{-- Sweet Alert --}}
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<style>
		.header-area {
    		background: none repeat scroll 0 0 #f4f4f4;
		}
		.header-area a {
			color: #888;
		}
		.user-menu ul {
			list-style: outside none none;
			margin: 0;
			padding: 0;
		}
		.user-menu li {
			display: inline-block;
		}
		.user-menu li a {
			display: block;
			font-size: 13px;
			margin-right: 5px;
			padding: 10px;
		}
		.user-menu li a i.fa {
			margin-right: 5px;
		}
		.button{ 
			font-size: 18px;
			border: 1px solid #e60f0f;
			padding: 13px 38px 13px 38px;
			border-radius: 10px;
			color: rgb(255, 255, 255);
			background: rgb(220, 50, 32);
			letter-spacing: 1px;
		}
		.button:hover{ 
			color: #ffffff;
			background: #a00d0d;
			border-color: #a00d0d;
		}
		.navbar-nav1  {
			list-style-type: none;
			margin: 0;
			padding: 0;
			overflow: hidden;
			float: right;
		}
		
		.hvr-underline-from-center1 {
			float: left;
		}
	</style>
  </head>
<body>
	<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v12.0&appId=4786925174735123&autoLogAppEvents=1" nonce="2hhNVvRJ"></script>
	@include('layout.header_home')

	<section id="header" class="cd-secondary-nav">
		<div class="container">
		 <div class="row">
			  <nav class="navbar navbar-default">
			   <!-- Brand and toggle get grouped for better mobile display -->
			   <div class="navbar-header">
			   {{-- <button type="button" style="padding-bottom:5px; margin-bottom: 15px; padding-right:10px" class="navbar-toggle" data-toggle="collapse" data-target="#dropdown-thumbnail-preview">
				   <span class="sr-only">Toggle navigation</span>
				   <span class="icon-bar"></span>
				   <span class="icon-bar"></span>
				   <span class="icon-bar"></span>
			   </button> --}}
			   </div>
			   <ul class="nav navbar-nav" style="float: left; padding-top: 0px;">
				<li style="margin-left: 80px"></li>
				<li class="active"><a href="{{ url('/') }}" class="hvr-underline-from-center1">TRANG CHỦ</a></li>
				<li><a href="{{ url('page-category') }}" class="hvr-underline-from-center1">MENU</a></li>
				<li><a href="{{ url('page-news') }}" class="hvr-underline-from-center1">TIN TỨC</a></li>
				<li><a href="{{ url('page-contact') }}" class="hvr-underline-from-center1">LIÊN HỆ</a></li>
			</ul>
			   </nav>
			 </div>
		 </div>
	   </section>

@yield('content')

<section id="footer" class="clearfix" >
	<div class="col-sm-12 space_all"style="display: flex;">
	<div class="col-sm-3">
	  <div class="footer_1">
	   <h4>TIÊU CHÍ</h4>
	  <p>Hương vị độc đáo, phong cách phục vụ thân thiện, 
		  hết lòng vì khách hàng và bầu không khí nồng nhiệt, 
		  ấm cúng tại các nhà hàng là ba chìa khóa chính mở cánh cửa thành công của Hurricane
		  đã tạo nên một nét văn hóa ẩm thực và đóng góp vào sự phát triển của ngành 
		  công nghiệp thức ăn nhanh.</p>
	  </div>
	  </div>
	  <div class="col-sm-2">
		<div class="footer_2">
	   <h4>MENU</h4>
	  <ul>
		  @php($get_menu = DB::table('categories')->get())
		  @foreach($get_menu as $data)
				 <li class="float-left">
				  <a href="{{ url('page-product/'.Str::slug($data->category_name).'/'.$data->id) }}">{{ $data->category_name }}</a>
			  </li>
		  @endforeach
		  <li>
			  <a href="{{ url('page-combo') }}">Combo</a>
		  </li>
	  </ul>
	  </div>
	  </div>
	  <div class="col-sm-3">
		  <div class="footer_3">
			  <h4 class="float-left">KHẨU HIỆU </h4>
			  <p class="float-left">Hurricane! Thà nhịn nói chứ không nhịn đói!!!</p>
			  <input type="text" class="form-control" placeholder="Nhập email của bạn để phản hồi"><br>
			  <a href="{{ url('page-contact') }}" class="button">Phản hồi</a>
		  </div>
	  </div>
	  <div class="col-sm-4">
	   <div class="footer_4">
	   <h4>THÔNG TIN LIÊN LẠC</h4>
		<ul>
		   <li><i class="fa fa-map-marker"></i>Address: 26C2 P.An Bình, Q.Ninh Kiều, TPCT</li>
		   <li><i class="fa fa-phone"></i>Phones: <a href="#">07116-196-984</a></li>
		   <li><i class="fa fa-user"></i>Quản lý cửa hàng: Nguyễn Văn A.</li>
		   <li><i class="fa fa-envelope"></i>E-mail:<a href="#"> hurricane@gmail.com</a></li> 
	   </ul>
	  </div>
	  </div>
	</div>
  </section>
  
  @if(session()->has('message1'))
  <script>
	  Swal.fire({
		  position: 'center',
		  icon: 'success',
		  title: 'Đăng nhập thành công!',
		  showConfirmButton: false,
		  timer: 2000
	  })
  </script>
@endif
<script>
	$(document).ready(function(){
		/*****Fixed Menu******/
		var secondaryNav = $('.cd-secondary-nav'),
		secondaryNavTopPosition = secondaryNav.offset().top;
			$(window).on('scroll', function(){
				if($(window).scrollTop() > secondaryNavTopPosition ) {
					secondaryNav.addClass('is-fixed');	
				} else {
					secondaryNav.removeClass('is-fixed');
				}
			});	
			
	});
</script>

<script>
		$(document).ready(function() {
		$('#Carousel').carousel({
			interval: 5000
		})
	});
</script>

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>

<script>
	function nonlogin(msg){
		if(window.confirm(msg)){
			return true;
		}
		return false;
	}
</script>
</body>

<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
	var chatbox = document.getElementById('fb-customer-chat');
	chatbox.setAttribute("page_id", "109964111520508");
	chatbox.setAttribute("attribution", "biz_inbox");

	window.fbAsyncInit = function() {
		FB.init({
		xfbml            : true,
		version          : 'v12.0'
		});
	};

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

</html>