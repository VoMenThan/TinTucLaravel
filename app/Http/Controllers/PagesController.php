<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\TheLoai;
use App\Slider;
use App\LoaiTin;
use App\TinTuc;
use App\User;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
	function __construct()
	{
		$theloai =  TheLoai::all();
		view()->share('theloai', $theloai);

		$slider = Slider::all();
		view()->share('slider', $slider);
	}
	public function trangchu()
	{
    	return view('pages.trangchu');
	}
	public function lienhe()
	{
    	return view('pages.lienhe');
	}
	public function gioithieu()
	{
    	return view('pages.gioithieu');
	}
	public function loaitin($id)
	{
		$loaitin = LoaiTin::find($id);
		$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
    	return view('pages.loaitin',['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
	}

	public function tintuc($id)
	{
		$tintuc = TinTuc::find($id);
		$noibat = TinTuc::where('NoiBat', 1)->take(4)->get();
		$lienquan = TinTuc::where('idLoaiTin', $id)->take(4)->get();

    	return view('pages.tintuc',['tintuc'=>$tintuc, 'noibat'=>$noibat, 'lienquan'=>$lienquan]);
	}


	public function getDangnhap()
	{
		return view('pages.dangnhap');
	}

	public function postDangnhap(Request $request)
	{	
		$this->validate($request, [
            'email'=>'required',
            'password'=> 'required|min:3|max:32'
        ],[
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=> 'Bạn chưa nhập mật khẩu',
            'password.min'=> 'Mật khẩu tối thiểu 3 và tối đa là 32 ký tự',
            'password.max'=> 'Mật khẩu tối thiểu 3 và tối đa là 32 ký tự'
        ]);


        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
            return redirect('trangchu');
        }else{
            return redirect('dangnhap')->with('thongbao', 'Đăng nhập không thành công');
        }	
		
	}

	public function getDangxuat()
	{
		Auth::logout();
		return redirect('dangnhap');

	}

	public function  getDangky()
	{
		return view('pages.dangky');
	}
	public function  postDangky(Request $request)
	{
		$this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=> 'required|min:3|max:32',
            'passwordAgain'=> 'required|same:password'
        ],[
            'name.required'=>'Bạn chưa nhập tên',
            'email.required'=>'Bạn chưa nhập email',
            'email.email'=>'Bạn chưa phải email',
            'email.unique'=>'Email đã tồn tại vui long chọn email khác',
            'password.required'=> 'Bạn chưa nhập mật khẩu',
            'password.min'=> 'Mật khẩu tối thiểu 3 và tối đa là 32 ký tự',
            'password.max'=> 'Mật khẩu tối thiểu 3 và tối đa là 32 ký tự',
            'passwordAgain.required'=> 'Bạn chưa nhập lại mật khẩu',
            'passwordAgain.same'=> 'Mật khẩu không trùng khớp'
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->quyen = 0;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect('dangnhap')->with('thongbao', 'Đăng ký thành công!');
	}

	public function getNguoidung()
	{
		return view('pages.nguoidung');
	}
	public function postNguoidung(Request $request)
	{
		$this->validate($request,[
            'name' => 'required|min:3'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'name.min' => 'Tên người dùng tối thiểu 3 ký tự'
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        if ($request->changePass == "on") {
                $this->validate($request,[
                'password' => 'required|min:6|max:32',
                'passwordAgain' => 'required|same:password'
            ],[
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu tối thiểu 6 và tối đa 32 ký tự',
                'password.max' => 'Mật khẩu tối thiểu 6 và tối đa 32 ký tự',

                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same' => 'Mật khẩu không trùng khớp'
            ]);

            $user->password = bcrypt($request->password);
        }
        

        $user->save();

        return redirect('nguoidung')->with('thongbao', 'Sửa thành công!');
	}

	public function timkiem(Request $request)
	{
		$tukhoa = $request->tukhoa;

		$tintuc = TinTuc::where('TieuDe', 'like', "%$tukhoa%")->take(20)->paginate(10);

		return view('pages.timkiem', ['tintuc'=>$tintuc, 'tukhoa'=>$tukhoa]);
	}
    
}
