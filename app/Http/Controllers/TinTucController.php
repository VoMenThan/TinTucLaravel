<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;

class TinTucController extends Controller
{
    public function getDanhSach()
    {
        $tintuc = TinTuc::orderBy('id','asc')->get();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::where('idTheLoai', 1)->get();
    	return view('admin.tintuc.them', ['theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }
    public function postThem(Request $request)
    {
        $this->validate($request,
        [
            'TheLoai' => 'required',
            'LoaiTin' => 'required',
            'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
            'TomTat' => 'required',
            'NoiDung' => 'required',
            'NoiBat' => 'required'
        ],[
            'TheLoai.required' => 'Bạn chưa chọn thể loại',
            'LoaiTin.required' => 'Bạn chưa chọn loại',
            'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
            'TieuDe.min' => 'Tiêu đề ít nhất 3 ký tự',
            'TieuDe.unique' => 'Tiêu đề đã tồn tại',
            'TomTat.required' => 'Bạn chưa chọn tóm tắt',
            'NoiDung.required' => 'Bạn chưa chọn nội dung',
            'NoiBat.required' => 'Bạn chưa chọn nổi bật'
        ]);

        $tintuc = new TinTuc;

        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($tintuc->TieuDe);
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->SoLuotXem = 0;

        if ($request->hasFile('HinhAnh')) {
            $file = $request->file('HinhAnh');
            $name = $file->getClientOriginalName();
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'jpg' && $duoi != 'png') {
                return redirect('admin/tintuc/them')->with('loi', 'Bạn chọn file hình đuôi png jpg');
            }
            $Hinh = str_random(4)."_".$name;

            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = str_random(4)."_".$name;
            }
            $file->move('upload/tintuc/', $Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else{
            $tintuc->Hinh = "";
        }
        $tintuc->save();

        return redirect('admin/tintuc/them')->with('thongbao', 'Thêm thành công!');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua', ['tintuc'=>$tintuc, 'theloai'=>$theloai, 'loaitin'=>$loaitin]);
    }

    public function postSua(Request $request, $id)
    {
        $this->validate($request,
        [
            'TheLoai' => 'required',
            'LoaiTin' => 'required',
            'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
            'TomTat' => 'required',
            'NoiDung' => 'required',
            'NoiBat' => 'required'
        ],[
            'TheLoai.required' => 'Bạn chưa chọn thể loại',
            'LoaiTin.required' => 'Bạn chưa chọn loại',
            'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
            'TieuDe.min' => 'Tiêu đề ít nhất 3 ký tự',
            'TieuDe.unique' => 'Tiêu đề đã tồn tại',
            'TomTat.required' => 'Bạn chưa chọn tóm tắt',
            'NoiDung.required' => 'Bạn chưa chọn nội dung',
            'NoiBat.required' => 'Bạn chưa chọn nổi bật'
        ]);
        $tintuc = TinTuc::find($id);

        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($tintuc->TieuDe);
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->idLoaiTin = $request->LoaiTin;

        if ($request->hasFile('HinhAnh')) {
            $file = $request->file('HinhAnh');
            $name = $file->getClientOriginalName();
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'jpg' && $duoi != 'png') {
                return redirect('admin/tintuc/them')->with('loi', 'Bạn chọn file hình đuôi png jpg');
            }
            $Hinh = str_random(4)."_".$name;

            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = str_random(4)."_".$name;
            }
            $file->move('upload/tintuc/', $Hinh);

            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        
        $tintuc->save();

        return redirect('admin/tintuc/sua/'.$id)->with('thongbao', 'Sửa thành công!');

    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $comment = Comment::where('idTinTuc',$id)->get();

        if (count($comment) > 0) {
            foreach ($comment as $cm) {
                $xoacm = Comment::find($cm->id);
                $xoacm->delete();
            }
        }
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao', 'Xóa thành công!');
    }
}
