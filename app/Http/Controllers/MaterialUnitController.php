<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialUnitController extends Controller
{
    public function list()
    {
        return view('admin.material_unit');
    }
}
