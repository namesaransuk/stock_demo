<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Repositories\ProductInspectInterface;
use Illuminate\Http\Request;

class ProductInspectController extends Controller
{
    private $productInspectRepository;

    public function __construct(ProductInspectInterface $productInspectRepository)
    {
        $this->productInspectRepository = $productInspectRepository;
    }

    public function getInspectDetail(Request $request)
    {
        $data = $request->all();
        $detail = $this->productInspectRepository->getInspectDetailByProductLotID($data['id']);
        // dd($detail);
        return $detail;
    }
}
