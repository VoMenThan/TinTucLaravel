@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
                    <small>{{$user->name}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            
            @if(session('thongbao'))
            <div class="alert alert-success">
                {{session('thongbao')}}
            </div>
            @endif
            
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                {{$err}}
                @endforeach
            </div>
            @endif
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="admin/user/sua/{{$user->id}}" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Tên</label>
                        <input class="form-control" name="Ten" placeholder="Nhập tên người dùng" value="{{$user->name}}" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="Email" placeholder="Nhập email của bạn" value="{{$user->email}}"  disabled="" />
                    </div>
            
                    <div class="form-group">
                        <input type="checkbox" id="changePass" name="changePass">
                        <label>Đổi mật khẩu</label>
                        <input class="form-control password" type="password" name="MatKhau" placeholder="Nhập mật khẩu" disabled="" />
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu</label>
                        <input class="form-control password" type="password" name="ReMatKhau" placeholder="Nhập lại mật khẩu" disabled="" />
                    </div>

                    <div class="form-group">
                        <label>Quyền</label>
                        <label class="radio-inline">
                            <input name="Quyen" value="0" 
                            @if($user->quyen == 0)
                            {{"checked"}}
                            @endif
                             type="radio">Người dùng
                        </label>
                        <label class="radio-inline">
                            <input name="Quyen" value="1"
                            @if($user->quyen == 1)
                            {{"checked"}}
                            @endif
                              type="radio">Admin
                        </label>
                        
                    </div>
                    
                    <button type="submit" class="btn btn-default">Thêm</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){
            $('#changePass').change(function(){
                if ($(this).is(":checked")) {
                    $(".password").removeAttr('disabled');
                }
                else{
                    $(".password").attr('disabled','');
                }
            });
        });
    </script>
@endsection