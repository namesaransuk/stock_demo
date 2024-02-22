<?php

namespace App\Http\Controllers;

use App\Repositories\MaterialInterface;
use App\Repositories\CategoryInterface;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    private $categoryRepository;
    private $materialRepository;
    private $vendorRepository;
    public function __construct(CategoryInterface $categoryRepository, MaterialInterface $materialRepository, VendorInterface $vendorRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->materialRepository = $materialRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function list()
    {
        $categories = $this->categoryRepository->all()->where('product_import_flag', '=', '1');
        $brands = $this->vendorRepository->all()->where('type', '=', '1');
        return view('admin.material', compact('categories', 'brands'));
    }

    public function export()
    {
        $get_all = $this->materialRepository->getAllMaterial();

        foreach ($get_all as $row) {
            $mName = $row->name;
            $mBrand = '';
            if ($row->brandVendor) {
                $mBrand = $row->brandVendor->brand;
            }

            $sql = DB::table('material_lots')
                ->selectRaw('getBalanceMaterialStockByMaterialID(' . $row->id . ') as remain')
                ->first();

            $mRemain = $sql->remain;
            $mUnit = 'กรัม';
            if ($mRemain >= 1000000) {
                $mRemain = floatval($mRemain / 1000000);
                $mUnit = 'ตัน';
            } else if ($mRemain >= 1000) {
                $mRemain = floatval($mRemain / 1000);
                $mUnit = 'กิโลกรัม';
            }
            $data[] = [
                'ID' => $row->id,
                'name' => $mName . ' : ' . $mBrand,
                'remain' => $mRemain,
                'unit' => $mUnit
            ];
        }
        return FastExcel::data($data)->download('material_' . date('d_M_Y-h-i-s-A') . '.xlsx');
    }
}
