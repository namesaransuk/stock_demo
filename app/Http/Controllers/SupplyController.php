<?php

namespace App\Http\Controllers;

use App\Repositories\SupplyInterface;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    public function __construct(SupplyInterface $supply_impl) {
        $this->supply_impl = $supply_impl;
    }

    public function list()
    {
    return view('admin.supply');
    }

    public function supplyChart(Request $request)
    {
        $data = $this->supply_impl->dataChart();

        return response()->json($data);
    }

    public function export()
    {
        $get_all = $this->supply_impl->getAll();

        foreach ($get_all as $row) {
            $sql = DB::table('supply_lots')
            ->selectRaw('getBalanceSupplyStockBySupplyID('.$row->id.') as remain')
            ->first();
            $data[] = [
                'ID' => $row->id,
                'name' => $row->name,
                'remain' => $sql->remain,
                'unit' => 'ชิ้น'
            ];
        }
        return FastExcel::data($data)->download('supply_' . date('d_M_Y-h-i-s-A') . '.xlsx');
    }
}
