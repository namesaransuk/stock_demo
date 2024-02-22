<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function list()
    {
    return view('admin.role');
    }
}
