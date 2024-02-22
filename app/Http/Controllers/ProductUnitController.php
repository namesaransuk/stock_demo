<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    public function list()
    {
        return view('admin.product_unit');
    }
}
