<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryInterface;
use App\Repositories\FdaBrandInterface;
use App\Repositories\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ProductController extends Controller
{
    private $categoryRepository;
    private $fdaBrandRepository;
    private $productRepository;
    public function __construct(CategoryInterface $categoryRepository, ProductInterface $productRepository, FdaBrandInterface $fdaBrandRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->fdaBrandRepository = $fdaBrandRepository;
        $this->productRepository = $productRepository;
    }

    public function list()
    {
        $categories = $this->categoryRepository->all();
        $brands = $this->fdaBrandRepository->all();
        return view('admin.product', compact('categories','brands'));
    }

    public function export()
    {
        $get_all = $this->productRepository->getAll();

        foreach ($get_all as $row) {
            $sql = DB::table('product_lots')
                ->selectRaw('getBalanceProductStockByProductID(' . $row->id . ') as remain')
                ->first();
            $data[] = [
                'ID' => $row->id,
                'name' => $row->name,
                'remain' => $sql->remain,
                'unit' => 'ชิ้น'
            ];
        }
        return FastExcel::data($data)->download('product_' . date('d_M_Y-h-i-s-A') . '.xlsx');
    }
}
