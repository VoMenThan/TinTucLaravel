<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    public function getDanhSach()
    {
        $loaitin = LoaiTin::all();
        return view('admin.loaitin.danhsach', ['loaitin'=>$loaitin]);
    }



    public function getThem()
    {
        $theloai = TheLoai::all();
        return view('admin.loaitin.them',['theloai'=>$theloai]);
    }

    public function postThem(Request $request)
    {

        $this->validate($request,
        [
            'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100',
            'idTheLoai' => 'required'
        ],
        [
            'Ten.required' => "Bạn chưa nhập tên loại",      
            'Ten.unique' => "Loại tin đã tồn tại",      
            'Ten.min' => "Tên loại phải trên 3 và dưới 100 ký tự",      
            'Ten.max' => "Tên loại phải trên 3 và dưới 100 ký tự",
            'idTheLoai.required' => "Chưa chọn thể loại" 
        ]);

        $loaitin = new LoaiTin;

        $loaitin->Ten = $request->Ten;
        $loaitin->idTheLoai = $request->idTheLoai;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao', 'Thêm thành công!');
    }



    public function getSua($id)
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
       return view('admin.loaitin.sua',['loaitin'=>$loaitin, 'theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id)
    {
       $this->validate($request, 
        [
            'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100',
            'idTheLoai' => 'required'
       ],[
            'Ten.required' => "Bạn chưa nhập tên loại",
            'Ten.unique' => "Tên loại đã tồn tại",
            'Ten.min' => "Tối thiểu 3 và tối đa 100 ký tự",
            'Ten.max' => "Tối thiểu 3 và tối đa 100 ký tự",
            'idTheLoai.required' => "Bạn chưa nhập tên thể loại"
       ]);

       $loaitin = Loaitin::find($id);

       $loaitin->Ten = $request->Ten;
       $loaitin->TenKhongDau = changeTitle($request->Ten);
       $loaitin->idTheLoai = $request->idTheLoai;
       $loaitin->save();

       return redirect('admin/loaitin/sua/'.$id)->with('thongbao','Sửa thành công!');
    }



    public function getXoa($id)
    {
        $loaitin = Loaitin::find($id);
        $loaitin->delete();

        return redirect('admin/loaitin/danhsach')->with('thongbao', 'Xóa thành công!');
    }
}
