<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function list()
    {
        return view('admin.vendor');
    }
}
