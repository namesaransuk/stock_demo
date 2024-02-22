<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FdaBrandInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingUnitInterface;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class PackagingController extends Controller
{
    private $fdaBrandRepository;
    private $packageRepository;
    private $packageUnitRepository;
    public function __construct(FdaBrandInterface $fdaBrandRepository, PackagingInterface $packageRepository, PackagingUnitInterface $packageUnitRepository)
    {
        $this->fdaBrandRepository = $fdaBrandRepository;
        $this->packageRepository = $packageRepository;
        $this->packageUnitRepository = $packageUnitRepository;
    }

    public function list()
    {
        $packagingUnits = $this->packageUnitRepository->all();
        $brands = $this->fdaBrandRepository->all();
        return view('admin.packaging', compact('packagingUnits', 'brands'));
    }

    public function export()
    {
        $get_all = $this->packageRepository->getAll();

        foreach ($get_all as $row) {
            $sql = DB::table('packaging_lots')
                ->selectRaw('getBalancePackagingStockByPackagingID(' . $row->id . ') as remain')
                ->first();
            $data[] = [
                'ID' => $row->id,
                'name' => $row->name,
                'remain' => $sql->remain,
                'unit' => $row->volumetric_unit,
            ];
        }
        return FastExcel::data($data)->download('packaging_' . date('d_M_Y-h-i-s-A') . '.xlsx');
    }
}
