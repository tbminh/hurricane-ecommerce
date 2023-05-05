<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thêm người dùng</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('post-add-admin') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="">Quyền truy cập</label>
                    <select name="inputRoleId" class="form-control" required>
                        <option value=""> --Chọn--</option>
                        @php($get_roles = DB::table('role_accesses')->get())
                        @foreach($get_roles as $value)
                            <option value="{{ $value->id }}" >
                                {{$value->role_name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Họ và tên:</label>
                    <input type="text" name="inputFullName" class="form-control"
                           placeholder="Nhập họ và tên" required>
                </div>
                <div class="form-group">
                    <label for="">Tên đăng nhập:</label>
                    <input type="text" name="inputUserName" class="form-control"
                           placeholder="Nhập tên đăng nhập" required>
                    {{-- <small class="text-danger">{{ $errors->first('inputUserName') }}</small> --}}
                </div>

                <div class="form-group">
                    <label for="">Mật khẩu</label>
                    <input type="password" name="inputPassword" class="form-control"
                           placeholder="Nhập mật khẩu" required>
                </div>

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="inputEmail" class="form-control"
                           placeholder="Nhập email" >
                    {{-- <small class="text-danger">{{ $errors->first('inputEmail') }}</small> --}}
                </div>

                <div class="form-group">
                    <label for="">Địa chỉ</label>
                    <input type="name" name="inputAddress" class="form-control"
                           placeholder="Nhập địa chỉ" required>
                </div>

                <div class="form-group">
                    <label for="">Số điện thoại</label>
                    <input type="number" name="inputPhoneNumber" class="form-control"
                           placeholder="Nhập số điện thoại">
                </div>

                <div class="form-group">
                    <label for="">Giới tính</label>
                    <br/>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="inputSex" value="0">Nam
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="inputSex" value="1">Nữ
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="inputSex" value="2">Khác
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" class="form-control-file" id="imgInp" name="inputFileImage">
                    <img id="blah" src="#" style="max-width:100%;height:50px;border-radius:5px;"/>
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