<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CosmeticsController extends Controller
{
    public function list()
    {
        return view('admin.cosmetics');
    }
}
