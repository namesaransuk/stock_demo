<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrefixController extends Controller
{
    public function list()
    {
    return view('admin.prefix');
    }
}
