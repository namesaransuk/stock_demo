<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplementController extends Controller
{
    public function list()
    {
        return view('admin.supplement');
    }
}
