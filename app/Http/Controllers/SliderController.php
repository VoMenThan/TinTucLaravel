<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function getDanhSach()
    {
    	return view('admin.slider.danhsach');
    }

    public function getSua()
    {
    	return view('admin.slider.sua');
    }

    public function getThem()
    {
    	return view('admin.slider.them');
    }
}
