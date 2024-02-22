<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Repositories\PackagingInspectInterface;
use Illuminate\Http\Request;

class PackagingInspectController extends Controller
{
    private $packagingInspectRepository;

    public function __construct(PackagingInspectInterface $packagingInspectRepository)
    {
        $this->packagingInspectRepository = $packagingInspectRepository;
    }

    public function getInspectDetail(Request $request)
    {
        $data = $request->all();
        $detail = $this->packagingInspectRepository->getInspectDetailByPackagingLotID($data['id']);
        // dd($detail);
        return $detail;
    }
}
