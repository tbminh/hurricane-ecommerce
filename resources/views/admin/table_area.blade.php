@extends('layout.layout_admin')
@section('title','Trang Bàn Ăn Khu Vực')

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{'page-admin'}}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh sách sản phẩm</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    @if(session()->has('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Đã thêm thành công!',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @elseif(session()->has('delete'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Đã xóa bàn!',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
    <section class="content">
        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            BÀN ĂN - KHU VỰC
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus-circle"></i> Thêm bàn mới
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-1">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Khu Vực</th>
                                    <th>Bàn</th>
                                    <th>Sức chứa</th>
                                    <th>Trạng Thái</th>
                                    <th colspan="2">Tùy chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($show_tables as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            @php($get_area = DB::table('table_area')->where('id',$data->area_id)->first())
                                            {{ $get_area->area_name }}
                                        </td>
                                        <td>{{ $data->table_name }}</td>
                                        <td>{{ $data->table_capacity }}</td>
                                        <td>
                                            @if($data->table_status == 0)
                                                <b style="color: grey; font-size: 14px;">
                                                    <i class="fa fa-times"></i> Chưa đặt
                                                </b>
                                            @else
                                                <b style="color: green; font-size: 14px;">
                                                   <i class="fa fa-check"></i> Đã đặt
                                                </b>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="{{ url('delete-table/'.$data->id) }}" role="button" onclick="return confirm('Bạn có chắc muốn xóa không?');">
                                                <i class="fa fa-trash"></i> Xóa Bàn
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{ $data->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Thêm bàn mới</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('edit-table/'.$data->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="">Khu Vực</label>
                                                        <select name="inputArea" class="form-control">
                                                            @php($get_name = DB::table('table_area')->where('id',$data->area_id)->first())
                                                            <option value="{{ $get_name->id }}">{{ $get_name->area_name }}</option>
                                                            <option value="">-- Chọn Khu Vực --</option>
                                                            @php($get_area = DB::table('table_area')->get())
                                                            @foreach($get_area as $value)
                                                                @if($value->id == $get_name->id)
                                                                    @continue
                                                                @else
                                                                    <option value="{{ $value->id }}">
                                                                        {{$value->area_name}}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Tên bàn</label>
                                                        <input type="text" name="inputName" class="form-control" placeholder="Nhập tên sản phẩm" value="{{ $data->table_name }}">
                                                        <div class="invalid-feedback">Chưa nhập tên bàn</div>
                                                    </div>
                                
                                                    <div class="form-group">
                                                        <label for="">Sức chứa</label>
                                                        <input type="number" name="inputCapacity" class="form-control" placeholder="Nhập số lượng" value="{{ $data->table_capacity }}">
                                                    </div>
                                
                                                    <div class="form-group row">
                                                        <div class="col-12 text-right">
                                                            <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-xl-end" style="margin:20px 0">
                            {{ $show_tables->links() }}
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Thêm bàn mới</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('add-table') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Khu Vực</label>
                        <select name="inputArea" class="form-control">
                            <option value=""> --Chọn--</option>
                            @php($get_area = DB::table('table_area')->get())
                            @foreach($get_area as $value)
                                <option value="{{ $value->id }}">
                                    {{$value->area_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Tên bàn</label>
                        <input type="text" name="inputName" class="form-control" placeholder="Nhập tên sản phẩm">
                        <div class="invalid-feedback">Chưa nhập tên bàn</div>
                    </div>

                    <div class="form-group">
                        <label for="">Sức chứa</label>
                        <input type="number" name="inputCapacity" class="form-control" placeholder="Nhập số lượng">
                    </div>

                    <div class="form-group row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    
    
@endsection