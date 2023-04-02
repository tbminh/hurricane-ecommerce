@extends('layout.layout')
@section('title','Trang chủ')
@section('content')
<style>
    .carousel-inner{
        height: 600px;
    }
    .carousel-inner .carousel-item .carousel-caption{
        top: 480px;
    }
    .carousel-inner .carousel-item h5,span{
        color: #fff;
    }
    @media screen and (max-width: 576px) {
        .carousel-inner{
            height: 230px;
        }
        .carousel-inner .carousel-item .carousel-caption{
            top: 80px;
        }
    }
</style>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active" >
            <img class="d-block w-100" src="https://i.pinimg.com/originals/39/d4/5a/39d45aa61ce17e003144ce2e1cedefb7.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Chất Lượng</h5>
                <span>Cam kết luôn luôn cung cấp chất lượng sản phẩm tốt nhất cho từng khách hàng</span>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="https://static3.bigstockphoto.com/4/2/3/large1500/324149785.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Dịch vụ</h5>
                <span>Tươi cười mang cảm giác thân thiện cho khách hàng</span>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="https://hdwallsource.com/img/2019/4/fast-food-burgers-wallpaper-68908-71254-hd-wallpapers.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Thời gian nhanh chóng</h5>
                <span>Phục vụ nhanh, hạn chế thời gian chờ lâu cho khách hàng</span>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
   <section id="since">
    <div class="container">
     <div class="row">
      <div class="col-sm-6">
       <div class="since_1">
        <h1>Thấu hiểu nhu cầu khách hàng!!</h1>
        <p>Nắm bắt nhu cầu của người tiêu dùng Việt Nam hiện nay, 
            chúng tôi mong muốn phục vụ những bữa ăn nhanh nhưng hợp vệ sinh, 
            đầy đủ dưỡng chất cùng với cung cách phục vụ chuyên nghiệp, 
            Hurricane cam kết sẽ làm bạn hài lòng với dòng sản phẩm nổi tiếng 
            Không chỉ nổi tiếng về thức ăn ngon, Hurricane còn nổi tiếng về 
            chuỗi tiêu chuẩn Chất Lượng, Dịch Vụ, Vệ Sinh và Giá trị.</p>
        <a href="#" class="button"> ĐẶT NGAY </a>	 
       </div>
      </div>
      <div class="col-sm-6">
       <div class="since_2">
        <a href="#"><img src=" {{ asset('public/home/img/chicken1.png') }}" alt="abc" class="img_responsive"></a>
       </div>
      </div>
     </div>
    </div>
   </section>
   <section id="place">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="since_2">
                    <a href="#"><img src="{{ asset('public/home/img/test1.png') }} " alt="abc" class="img_responsive"></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="since_1">
                    <h1>Không ngừng nổ lực!</h1>
                    <p>Bên cạnh những món ăn truyền thống như gà rán và Bơ-gơ, chúng tôi đã chế biến
                        thêm một số món để phục vụ những thức ăn hợp khẩu vị người dùng như: Gà Big‘n Juicy, Gà Giòn Không Xương, 
                        Cơm Gà KFC, Bắp Cải Trộn … </p>
                    <p>Một số món mới cũng đã được phát triển và giới thiệu tại thị trường Việt Nam, 
                        góp phần làm tăng thêm sự đa dạng trong danh mục thực đơn, như: Bơ-gơ Tôm, Lipton, Bánh Egg Tart..</p>    
                    <a href="#" class="button"> ĐẶT NGAY </a>	 
                </div>
            </div>
        </div>
    </div>
</section>
{{-- </div> --}}

   @if(session()->has('checkouted'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Thanh toán thành công!',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
@endsection