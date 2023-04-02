@extends('layout.layout_admin')
@section('title','Trang quyền truy cập')

@section('link_css')
{{--    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>--}}
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('page-admin') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Quyền truy cập</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection


@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <!-- TO DO List -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                THÊM QUYỀN TRUY CẬP
                            </h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body p-1">
                            <form action="{{ url('post-add-role-access') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Tên quyền:</label>
                                    <input type="text" name="inputRoleName" class="form-control"
                                           placeholder="Nhập tên quyền..." required>
                                    <div class="invalid-feedback">Chưa nhập tên quyền</div>
                                    <small class="text-danger">{{ $errors->first('inputRoleName') }}</small>
                                </div>

                                <div class="form-group">
                                    <label for="">Mô tả</label>
                                    <textarea class="form-control" name="inputDescript" id="" rows="8" placeholder="Nhập mô tả..."></textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10 text-right">
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>

                <section class="col-lg-6 connectedSortable">
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
                                QUYỀN TRUY CẬP
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-1">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Quyền</th>
                                    <th>Chọn</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($show_user_roles as $key => $show_user_role)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $show_user_role->full_name }}</td>
                                    <td>
                                        @php($get_role = DB::table('role_accesses')->where('id',$show_user_role->role_id)->first())
                                            {{ $get_role->role_name }}
                                    </td>
                                    <td>
                                        @if($show_user_role->role_id == 1)
                                            <button class="btn btn-primary btn-sm" type="button" disabled>Thay đổi</>
                                        @else
                                            <button class="btn btn-primary btn-sm"  type="button" data-toggle="modal" data-target="#model{{ $show_user_role->id }}">Thay đổi</button>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="model{{ $show_user_role->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ url('update-role/'.$show_user_role->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">THAY ĐỔI QUYỀN </h5>
                                                </div>
                            
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">Họ tên</label>
                                                        <input type="text" name="inputName" class="form-control"
                                                        value="{{ $show_user_role->full_name }}" disabled>
                                                    </div>
                            
                                                    <div class="form-group">
                                                        <label>Quyền</label>
                                                        <select name="inputRoleId" class="form-control">
                                                            @php($get_roles = DB::table('role_accesses')->where('id',$show_user_role->role_id)->get())
                                                            <option value="{{ $get_role->id }}">{{ $get_role->role_name }}</option>

                                                            <option value="">- - Chọn quyền - -</option>
                                                            @php($get_role_2 = DB::table('role_accesses')->get())
                                                            @foreach($get_role_2 as $data)
                                                                @if ($data->id == $get_role->id) 
                                                                    @continue
                                                                @else
                                                                    <option value="{{ $data->id }}">{{ $data->role_name }}</option>
                                                                @endif
                                                                
                                                            @endforeach
                                                        </select>
                                                    </div>
                            
                                                    <div class="form-group ">
                                                        <div class="col-12 text-right">
                                                            <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                                </tbody>
                            </table>
                            <ul class="pagination justify-content-xl-end" style="margin:20px 0">
                                {{ $show_user_roles->links() }}
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>


    <script>
        CKEDITOR.replace( 'inputDescript' );
    </script>

    <script>
        // Disable form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Get the forms we want to add validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

@endsection
