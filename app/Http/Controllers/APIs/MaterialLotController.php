<?php

namespace App\Http\Controllers\APIs;

use App\Models\MaterialLot;
use App\Models\Vendor;
use App\Http\Controllers\Controller;
use App\Repositories\MaterialLotInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\VendorInterface;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MaterialLotController extends Controller
{
    private $materialLotRepository;
    private $receiveMaterialRepository;
    private $vendorRepository;
    public function __construct(MaterialLotInterface $materialLotRepository, ReceiveMaterialInterface $receiveMaterialRepository, VendorInterface $vendorRepository)
    {
        $this->materialLotRepository = $materialLotRepository;
        $this->receiveMaterialRepository = $receiveMaterialRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function lotDatetime(Request $request)
    {
        // $lot = $this->materialLotRepository->all();
        // return $lot;

        $query = $request->get('query'); // รับคำค้นหาจากคำขอ

        $datetime = Carbon::now()->format('Y-m-d');
        $results = MaterialLot::where([
            ['lot', 'like', $query . '%'],
            ['created_at', 'like', $datetime . '%']
        ])->get();

        return $results;
    }

    public function updateLotNoPM(Request $request)
    {
        $data = $request->all();
        $material_lot_id = $this->materialLotRepository->find($request->id);
        $receive_material_id = $this->receiveMaterialRepository->find($material_lot_id->receive_material_id);
        // $vendor_id = Vendor::where('id', $receive_material_id->brand_vendor_id)->count();
        // $vendor_id = $this->vendorRepository->find($receive_material_id->brand_vendor_id)->count();
        $existingDataCount = MaterialLot::where('lot', $material_lot_id->lot)->count();

        // if ($data['lot_no_pm'] == "") {
        //     $data['lot_no_pm'] = null;
        // }

        $datetime = Carbon::createFromFormat("Y-m-d H:i:s", $receive_material_id->date);
        $date = $datetime->format('dmy');

        // ========================= Supplier =========================
        $currentLot = 'RM'
            . ($material_lot_id->company_id == 1 ? "C" : ($material_lot_id->company_id == 2 ? "G" : ($material_lot_id->company_id == 3 ? "I" : "0")))
            . $date;

        // $currentDateTime = Carbon::now('Asia/Bangkok');
        // if ($currentDateTime->format('H:i') >= '00:00' && $vendor_id == 0) {
        // $lotSup = 'A';
        // }

        if ($existingDataCount == 1) {
            $dataMaterial = MaterialLot::where('lot_no_pm', 'like', $currentLot . '%')->orderBy('id', 'desc')->first();
            if (isset($dataMaterial)) {
                $subData1 = substr($dataMaterial->lot_no_pm, 9);
                $existingLot = substr($subData1, 0, -1);
                $nextLot = chr(ord($existingLot) + 1); // เปลี่ยนจาก A เป็น B, B เป็น C, ...
                if ($nextLot > 'Z') {
                    $nextLot = 'A'; // ถ้าเกิน Z ให้เริ่มต้นที่ A ใหม่
                }
                $lotSup = $nextLot;
            } else {
                $lotSup = 'A';
            }
        } else {
            $lotSup = 'A';
        }

        // ========================= ครั้งที่รับเข้า =========================
        $prefix = 'RM'
            . ($material_lot_id->company_id == 1 ? "C" : ($material_lot_id->company_id == 2 ? "G" : ($material_lot_id->company_id == 3 ? "I" : "0")))
            . $date
            . $lotSup;

        $numRunning = null;

        if ($existingDataCount > 1) {
            $latestData = MaterialLot::where('lot_no_pm', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
            if (isset($latestData)) {
                $latestNumber = (int)substr($latestData->lot_no_pm, 10);
                $numRunning = $latestNumber + 1;
            } else {
                $numRunning = "1";
            }
        } else {
            $numRunning = "1";
        }

        $data['lot_no_pm'] = $prefix . $numRunning;
        $data += [
            'action' => 4
        ];
        // $update_lot_no_pm = $this->materialLotRepository->update($request->id, $data);
        $update_lot_no_pm = MaterialLot::where('lot', $material_lot_id->lot)->get();
        foreach ($update_lot_no_pm as $lot) {
            if (isset($lot)) {
                $lot->lot_no_pm = $data['lot_no_pm'];
                $lot->action = $data['action'];
                // $lot->material_id = $data['material_id'];
                $lot->save();
            }
        }

        // $result['test'] = $data['lot_no_pm'];
        return $update_lot_no_pm;
    }
}
