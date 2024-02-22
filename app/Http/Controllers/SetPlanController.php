<?php

namespace App\Http\Controllers;

use App\Models\SetPlan;
use App\Repositories\SetPlanInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SetPlanController extends Controller
{
    public function __construct(SetPlanInterface $set_plan_impl) {
        $this->set_plan_impl = $set_plan_impl;
    }

    public function list()
    {
        return view('admin.set_plan');
    }

    public function listData(Request $request)
    {
        $data = SetPlan::whereDate('start', '>=', $request->start)
        ->whereDate('end',   '<=', $request->end)
        ->get(['id', 'event as title', 'start', 'end','color']);

        return response()->json($data);
    }

    public function crudData(Request $request)
    {
        return $this->set_plan_impl->crud($request);
    }
}
