@extends('layout.layout_admin')
@section('title', 'Trang quản trị viên')


@section('breadcrumb')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="page-admin">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Quản trị</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@include('admin.user_manage.add_user')

@section('content')
    <section class="content">
        <div class="wrapper">
            <div class="row">
                <section class="col-lg-12 connectedSortable">

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <!-- TO DO List -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            QUẢN TRỊ
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#exampleModal" >
                               <i class="fa fa-plus-circle"></i> Thêm mới
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-1">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Tài khoản</th>
                                <th>Hình ảnh</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Điện thoại</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($show_admins as $key => $data)
                            <tr>
                                <td> {{ ++$key }}</td>
                                <td>{{$data->full_name}}</td>
                                <td>{{$data->user_name}}</td>
                                <td>
                                    <img src="{{ url('public/home/upload_img/'.$data->avatar) }}"
                                         class="img-circle elevation-2" alt="User Image " width="30px" height="30px">
                                </td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->address}}</td>
                                <td>0{{$data->phone}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td>
                                        <td colspan="11">
                                            <b class="text-danger">Không có dữ liệu </b>
                                        </td>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            <section>
            </div>
        </div>
    </section
@endsection



