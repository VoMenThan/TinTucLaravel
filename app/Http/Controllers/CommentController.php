<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getDanhSach()
    {
    	return view('admin.comment.danhsach');
    }

    public function getSua()
    {
    	return view('admin.comment.sua');
    }

    public function getThem()
    {
    	return view('admin.comment.them');
    }
}
