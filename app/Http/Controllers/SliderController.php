<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;

class SliderController extends Controller
{
    public function getDanhSach()
    {
       $slider = Slider::all();
       return view('admin.slider.danhsach',['slider'=>$slider]);
    }

    public function getThem()
    {
        return view('admin.slider.them');
    }
    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required|min:3|max:100',
                'Hinh' => 'required',
                'NoiDung' => 'required|min:3|max:100',
                
            ],[
                'Ten.required' => 'Bạn chưa nhập tên',
                'Ten.min' => 'Tên phải lớn hơn 3 và bé hơn 100 ký tự',
                'Ten.max' => 'Tên phải lớn hơn 3 và bé hơn 100 ký tự',
                'Hinh.required' => 'Bạn chưa chọn hình',
                'NoiDung.required' => 'Bạn chưa nhập nội dung'
                
            ]);

        $slider = new Slider;
        $slider->Ten = $request->Ten;
        $slider->NoiDung = $request->NoiDung;
        $slider->link = $request->Link;

        if($request->hasFile('Hinh')){
            $file =  $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $hinh = str_random(4)."_".$name;
            while(file_exists('upload/slide/'.$hinh)){
                $hinh = str_random(4)."_".$name;
            }

            $file->move('upload/slide/', $hinh);
            $slider->Hinh = $hinh;
        }else{
            $slider->Hinh = '';
        }
        $slider->save();

        return redirect('admin/slider/them')->with('thongbao', 'Thêm slider thành công!');
    }

    public function getSua($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.sua', ['slider'=>$slider]);
    }

    public function postSua(Request $request, $id)
    {

        $this->validate($request,
            [
                'Ten' => 'required|min:3|max:100',
                'NoiDung' => 'required',
                
            ],[
                'Ten.required' => 'Bạn chưa nhập tên',
                'Ten.min' => 'Tên phải lớn hơn 3 và bé hơn 100 ký tự',
                'Ten.max' => 'Tên phải lớn hơn 3 và bé hơn 100 ký tự',
                'NoiDung.required' => 'Bạn chưa nhập nội dung'
                
            ]);

        $slider = Slider::find($id);
        $slider->Ten = $request->Ten;
        $slider->NoiDung = $request->NoiDung;
        $slider->link = $request->Link;

        if($request->hasFile('Hinh')){
            $file =  $request->file('Hinh');
            $name = $file->getClientOriginalName();
            $hinh = str_random(4)."_".$name;
            while(file_exists('upload/slide/'.$hinh)){
                $hinh = str_random(4)."_".$name;
            }

            $file->move('upload/slide/', $hinh);
            unlink('upload/slide/'.$slider->Hinh);
            $slider->Hinh = $hinh;
        }
        $slider->save();

        return redirect('admin/slider/sua/'.$id)->with('thongbao', 'Sửa slider thành công!');


    }

    public function getXoa($id)
    {
        $slider = Slider::find($id);
        $slider->delete();

        return redirect('admin/slider/danhsach')->with('thongbao', 'Xóa thành công!');
    }
}
