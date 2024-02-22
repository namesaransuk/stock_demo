<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackagingUnitController extends Controller
{
    public function list()
    {
        return view('admin.packaging_unit');
    }
}
