@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slider
                    <small>{{$slider->Ten}}</small>
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
                <form action="admin/slider/sua/{{$slider->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label>Tên</label>
                        <input class="form-control" name="Ten" placeholder="Nhập tên" value="{{$slider->Ten}}" />
                    </div>
                    <div class="form-group">
                        <label>Hình</label>
                        <p><img width="400px" src="upload/slide/{{$slider->Hinh}}" alt=""></p>
                        <input type="file" class="form-control" name="Hinh"/>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <input class="form-control" name="NoiDung" placeholder="Nhập nội dung" value="{{$slider->NoiDung}}"/>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input class="form-control" name="Link" placeholder="Nhập link" value="{{$slider->link}}"/>
                    </div>
                    
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection