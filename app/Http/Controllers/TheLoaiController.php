<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    public function getDanhSach()
    {
        $theloai = TheLoai::all();
    	return view('admin.theloai.danhsach', ['theloai'=>$theloai]);
    }

    public function getThem()
    {
    	return view('admin.theloai.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request, 
            [
                'Ten' => 'required|min:3|max:100'
            ],
            [
                'Ten.required' => 'Tên thể loại bắt buộc phải nhập',
                'Ten.min' => 'Tên thể loại phải nhiều hơn 3 và ít hơn 100 ký tự',
                'Ten.max' => 'Tên thể loại phải nhiều hơn 3 và ít hơn 100 ký tự'
            ]
        );

        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);

        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao', 'Thêm thể loại thành công!');

    }

    public function getSua($id)
    {
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua', ['theloai'=>$theloai]);
    }

    public function postSua(Request $request, $id)
    {
        
    }
}
