<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\FdaBrand;
use App\Models\PackagingLot;
use App\Repositories\PackagingLotInterface;
use App\Repositories\ReceivePackagingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PackagingLotController extends Controller
{
    private $packagingLotRepository;
    private $receivePackagingRepository;
    public function __construct(
        PackagingLotInterface $packagingLotRepository,
        ReceivePackagingInterface $receivePackagingRepository
    ) {
        $this->packagingLotRepository = $packagingLotRepository;
        $this->receivePackagingRepository = $receivePackagingRepository;
    }
    //
    public function updateLotNoPM(Request $request)
    {
        $data = $request->all();

        // $packaging_lot_id = $this->packagingLotRepository->find($request->id);
        // $receive_packaging_id = $this->receivePackagingRepository->find($packaging_lot_id->receive_packaging_id);
        // $brand = FdaBrand::where('id', $receive_material_id->brand_vendor_id)->count();
        // $existingDataCount = PackagingLot::where('lot', $packaging_lot_id->lot)->count();

        // // if ($data['lot_no_pm'] == "") {
        // //     $data['lot_no_pm'] = null;
        // // }

        // $datetime = Carbon::createFromFormat("Y-m-d H:i:s", $receive_packaging_id->date);
        // $date = $datetime->format('dmy');

        // // ========================= Supplier =========================
        // $currentLot = 'RM'
        //     . ($material_lot_id->company_id == 1 ? "C" : ($material_lot_id->company_id == 2 ? "G" : ($material_lot_id->company_id == 3 ? "I" : "0")))
        //     . $date;

        // // $currentDateTime = Carbon::now('Asia/Bangkok');
        // // if ($currentDateTime->format('H:i') >= '00:00' && $vendor_id == 0) {
        // // $lotSup = 'A';
        // // }

        // if ($existingDataCount == 1) {
        //     $dataMaterial = PackagingLot::where('lot_no_pm', 'like', $currentLot . '%')->orderBy('id', 'desc')->first();
        //     if (isset($dataMaterial)) {
        //         $subData1 = substr($dataMaterial->lot_no_pm, 9);
        //         $existingLot = substr($subData1, 0, -1);
        //         $nextLot = chr(ord($existingLot) + 1); // เปลี่ยนจาก A เป็น B, B เป็น C, ...
        //         if ($nextLot > 'Z') {
        //             $nextLot = 'A'; // ถ้าเกิน Z ให้เริ่มต้นที่ A ใหม่
        //         }
        //         $lotSup = $nextLot;
        //     } else {
        //         $lotSup = 'A';
        //     }
        // } else {
        //     $lotSup = 'A';
        // }

        // // ========================= ครั้งที่รับเข้า =========================
        // $prefix = 'RM'
        //     . ($material_lot_id->company_id == 1 ? "C" : ($material_lot_id->company_id == 2 ? "G" : ($material_lot_id->company_id == 3 ? "I" : "0")))
        //     . $date
        //     . $lotSup;

        // $numRunning = null;

        // if ($existingDataCount > 1) {
        //     $latestData = PackagingLot::where('lot_no_pm', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        //     if (isset($latestData)) {
        //         $latestNumber = (int)substr($latestData->lot_no_pm, 10);
        //         $numRunning = $latestNumber + 1;
        //     }
        // } else {
        //     $numRunning = 1;
        // }

        // $data['lot_no_pm'] = $prefix . $numRunning;

        $data += [
            'action' => 4
        ];
        // $update_lot_no_pm = $this->packagingLotRepository->update($request->id,$data);
        $result['test'] = $data['lot_no_pm'];
        return $result;
    }
}
