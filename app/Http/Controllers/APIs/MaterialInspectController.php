<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Repositories\MaterialInspectInterface;
use Illuminate\Http\Request;

class MaterialInspectController extends Controller
{
    private $materialInspectRepository;

    public function __construct( MaterialInspectInterface $materialInspectRepository)
    {
        $this->materialInspectRepository = $materialInspectRepository;
    }


    public function getInspectDetail(Request $request)
    {
        $data = $request->all();
        $detail = $this->materialInspectRepository->getInspectDetailByMaterialLotID($data['id']);
        // dd($detail);
        return $detail;
    }
}
