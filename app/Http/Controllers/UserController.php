<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getDanhSach()
    {
        $user = User::all();
    	return view('admin.user.danhsach', ['user'=>$user]);
    }

    public function getThem()
    {
        return view('admin.user.them');
    }
    public function postThem(Request $request)
    {
        $this->validate($request,[
            'Ten' => 'required|min:3',
            'Email' => 'required|email|unique:users,email',
            'MatKhau' => 'required|min:6|max:32',
            'ReMatKhau' => 'required|same:MatKhau'
        ],[
            'Ten.required' => 'Bạn chưa nhập tên',
            'Ten.min' => 'Tên người dùng tối thiểu 3 ký tự',

            'Email.required' => 'Bạn chưa nhập email',
            'Email.email' => 'Bạn nhập sai email',
            'Email.unique' => 'Email đã tồn tại',

            'MatKhau.required' => 'Bạn chưa nhập mật khẩu',
            'MatKhau.min' => 'Mật khẩu tối thiểu 6 và tối đa 32 ký tự',
            'MatKhau.max' => 'Mật khẩu tối thiểu 6 và tối đa 32 ký tự',

            'ReMatKhau.required' => 'Bạn chưa nhập lại mật khẩu',
            'ReMatKhau.sam' => 'Mật khẩu không trùng khớp'
        ]);

        $user = new User;

        $user->name = $request->Ten;
        $user->email = $request->Email;
        $user->quyen = $request->Quyen;
        $user->password = bcrypt($request->MatKhau);

        $user->save();

        return redirect('admin/user/danhsach')->with('thongbao', 'Thêm thành công!');

    }

    public function getSua($id)
    {
        $user = User::find($id);
    	return view('admin.user.sua',['user'=>$user]);
    }

    public function postSua(Request $request, $id)
    {
        $this->validate($request,[
            'Ten' => 'required|min:3'
        ],[
            'Ten.required' => 'Bạn chưa nhập tên',
            'Ten.min' => 'Tên người dùng tối thiểu 3 ký tự'
        ]);

        $user = User::find($id);
        $user->name = $request->Ten;
        $user->quyen = $request->Quyen;
        if ($request->changePass == "on") {
                $this->validate($request,[
                'MatKhau' => 'required|min:6|max:32',
                'ReMatKhau' => 'required|same:MatKhau'
            ],[
                'MatKhau.required' => 'Bạn chưa nhập mật khẩu',
                'MatKhau.min' => 'Mật khẩu tối thiểu 6 và tối đa 32 ký tự',
                'MatKhau.max' => 'Mật khẩu tối thiểu 6 và tối đa 32 ký tự',

                'ReMatKhau.required' => 'Bạn chưa nhập lại mật khẩu',
                'ReMatKhau.sam' => 'Mật khẩu không trùng khớp'
            ]);

            $user->password = bcrypt($request->MatKhau);
        }
        

        $user->save();

        return redirect('admin/user/sua/'.$id)->with('thongbao', 'Sửa thành công!');
    }

    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành công!');
    }


    public function getDangnhapAdmin()
    {
        return view('admin.login');
    }

    public function postDangnhapAdmin(Request $request)
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
            return redirect('admin/theloai/danhsach');
        }else{
            return redirect('admin/dangnhap')->with('thongbao', 'Đăng nhập không thành công');
        }
    }

    public function getDangXuat()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }
    
}
