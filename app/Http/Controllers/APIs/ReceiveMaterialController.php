<?php

namespace App\Http\Controllers\APIs;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\HistoryMaterialLot;
use App\Models\HistoryReceiveMaterial;
use App\Models\MaterialLot;
use App\Models\ReceiveMaterial;
use App\Models\TransportPic;
use App\Repositories\CompanyInterface;
use App\Repositories\HistoryReceiveMaterialInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\TransportPicInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ReceiveMaterialController extends Controller
{
    private $transportPicRepository;
    private $receiveMaterialRepository;
    private $materialRepository;
    private $conmpanyRepository;
    private $materialLotRepository;
    private $historyReceiveMaterialRepository;

    public function __construct(TransportPicInterface $transportPicRepository, ReceiveMaterialInterface $receiveMaterialRepository, MaterialInterface $materialRepository, CompanyInterface $conmpanyRepository, MaterialLotInterface $materialLotRepository, HistoryReceiveMaterialInterface $historyReceiveMaterialRepository)
    {
        $this->transportPicRepository = $transportPicRepository;
        $this->receiveMaterialRepository = $receiveMaterialRepository;
        $this->materialRepository = $materialRepository;
        $this->materialLotRepository = $materialLotRepository;
        $this->conmpanyRepository = $conmpanyRepository;
        $this->materialLotRepository = $materialLotRepository;
        $this->historyReceiveMaterialRepository = $historyReceiveMaterialRepository;
    }

    public function printMaterials(Request $request)
    {
        $data = $request->all();
        $paper_status = 1;
        $inspect_ready = 0;

        $materials = $this->receiveMaterialRepository->printMaterials($data['company_id'], $paper_status, $inspect_ready);

        return $materials;
    }

    public function list(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $inspect_ready = 0;
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "company_id" => $request->company_id,
            "rowperpage" => $rowperpage
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receiveMaterialRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveMaterialRepository->getAllReceiveMaterials($param, $searchValue, $paper_status, $inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveMaterialRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $materials = $this->receiveMaterialRepository->findAllById($data['id']);

        return [
            "data" => $materials,
        ];
    }

    public function listCheckReceiveMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $inspect_ready = 1;
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "company_id" => $request->company_id,
            "rowperpage" => $rowperpage
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receiveMaterialRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveMaterialRepository->getAllReceiveMaterials($param, $searchValue, $paper_status, $inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveMaterialRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPendingReceiveMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $inspect_ready = 1;
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receiveMaterialRepository->countPending();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveMaterialRepository->getAllPendingReceiveMaterials($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "company_id" => $request->company_id,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->receiveMaterialRepository->paginatePendingListReceiveMaterials($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function viewCheckReceiveMaterial(Request $request)
    {
        $data = $request->all();
        $materialsLot = $this->receiveMaterialRepository->findMaterialLotById($data['id']);
        return $materialsLot;
    }
    protected function validateCheck(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "lot" => ["required"],
            "tons" => ["required"],
            "kg" => ["required"],
            "grams" => ["required"],
            "exp" => ["required"],
            "mfg" => ["required"],
            "coa" => ["required"],
            // "paper_no" =>["required"],
            // "edit_times" => ["required"],
            // "date" =>["required"],



        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }
    protected function validateCheckReceive(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "paper_no" => ["required"],
            "edit_times" => ["required"],
            "date" => ["required"],



        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function createReceiveMaterial(Request $request)
    {
        DB::beginTransaction();
        $create_receive_material = null;
        try {
            $data = $request->all();
            if ($data['po_file']) {
                $po_name = save_image($data['po_file'], 500, '/po_material/');
            };

            $date = Carbon::now()->format('dmy');
            $code = "RRM{$date}";
            $lastestMaterial = ReceiveMaterial::where('paper_no', 'LIKE', $code . '%')->orderBy('id', 'DESC')->first();

            if (isset($lastestMaterial)) {
                $subRunning = substr($lastestMaterial->paper_no, 10);
                $nextRunning = (int)$subRunning + 1;
                $running = str_pad($nextRunning, 3, '0', STR_PAD_LEFT);
            } else {
                $running = '001';
            }
            $paper_no = $code . '-' . $running;

            $create_receive_material = ReceiveMaterial::create([
                // 'paper_no' => $data['paper_no'],
                'paper_no' => $paper_no,
                'edit_times' => 0,
                'date' => $data['date'],
                'brand_vendor_id' => $data['brand_vendor_id'],
                'logistic_vendor_id' => $data['logistic_vendor_id'],
                'stock_user_id' => $data['user_id'],
                'history_flag' => 1,
                'created_by' => $data['user_id'],
                'updated_by' => $data['user_id'],
                'po_no' => $data['po_no'],
                'company_id' => $data['company_id'],
                'po_file_name' => $po_name,
                'bill_no' => $data['bill_no']
            ]);

            foreach ($data['material'] as $material) {
                $coa = "0";
                if (isset($material['coa'])) {
                    $coa = save_image($material['coa'], 500, '/coa_material/');
                };
                $kg = $material['weight_kg'] * 1000;
                $tons = $material['weight_ton'] * 1000000;
                $total_weight = $kg + $tons + $material['weight_grams'];
                $raw_mat = $this->materialRepository->find($material['receive_mat_name']);

                // $update_transport_check = $this->materialLotRepository->update($create_material_lot->id, $data);
                $data['transport_check'] = 1;

                $create_material_lot = MaterialLot::create([
                    "lot_no_pm" => null,
                    "lot" => $material['lot'],
                    "weight_grams" => $material['weight_grams'],
                    "weight_kg" => $material['weight_kg'],
                    "weight_ton" => $material['weight_ton'],
                    "weight_total" => $total_weight,
                    "mfg" => $material['mfg'],
                    "coa" => $coa,
                    "exp" => $material['exp'],
                    "action" => "1",
                    "company_id" => $material['company_id'],
                    "material_id" => $raw_mat->id,
                    "receive_mat_name" => $raw_mat->name,
                    "receive_material_id" => $create_receive_material->id,
                    "sender_vehicle_plate" => $data['sender_vehicle_plate'],
                    "transport_check" => $data['transport_check']
                ]);

                $files = isset($data['file_name']) ? $data['file_name'] : null;
                if (isset($files)) {
                    foreach ($files as $file) {
                        $pic = save_image($file, 500, '/transport_pic/');
                        TransportPic::create([
                            'name' => $pic,
                            'created_by' => $data['user_id'],
                            'material_lot_id' => $create_material_lot->id,
                        ]);
                    }
                };
            }

            $result['status'] = 'success';
            DB::commit();
        } catch (\Exception $e) {
            // dd($e);
            $result['test'] = $create_receive_material;
            $result['message'] = $e->getMessage();
            DB::rollBack();
        }

        return $result;
    }

    public function editReceiveMaterial(Request $request)
    {

        $data = $request->all();
        $newedit_times = $data['edit_times'] + 1;
        $recap_old = $data['recapold'];
        if ($data['recapold'] === null) {
            $recap_old = " ";
        }
        DB::beginTransaction();
        $create_receive_material = null;
        try {
            $create_receive_material_history = HistoryReceiveMaterial::create([
                'paper_no' => $data['paper_no'],
                'po_no' => $data['po_no'],
                'po_file_name' => $data['po_file'],
                'edit_times' => $data['edit_times'],
                'date' => $data['date'],
                'history_flag' => $data['history_flag'],
                'created_by' => $data['created_by'],
                'updated_by' => $data['updated_by'],
                'receive_material_id' => $data['id'],
                'stock_user_id' => $data['stock_user_id'],
                'admin_user_id' => $data['admin_user_id'],
                'brand_vendor_id' => $data['brand_vendor_id'],
                'logistic_vendor_id' => $data['logistic_vendor_id'],
                'recap' => $recap_old,
                'company_id' => $data['company_id'],
            ]);

            foreach (json_decode($data['materialOld']) as $datamaterialOld) {
                $create_history_material_lot = HistoryMaterialLot::create([
                    "lot_no_pm" => $datamaterialOld->lot_no_pm,
                    "lot" => $datamaterialOld->lot,
                    "coa" => $datamaterialOld->coa,
                    "weight_grams" => $datamaterialOld->weight_grams,
                    "weight_kg" => $datamaterialOld->weight_kg,
                    "weight_ton" => $datamaterialOld->weight_ton,
                    "weight_total" => $datamaterialOld->weight_total,
                    "mfg" => $datamaterialOld->mfg,
                    "exp" => $datamaterialOld->exp,
                    "action" => $datamaterialOld->action,
                    "quality_check" => $datamaterialOld->quality_check,
                    "transport_check" => $datamaterialOld->transport_check,
                    "notation" => $datamaterialOld->notation,
                    "company_id" => $datamaterialOld->company_id,
                    "material_id" => $datamaterialOld->material_id,
                    "receive_material_id" => $datamaterialOld->receive_material_id,
                    "history_receive_material_id" => $create_receive_material_history->id,
                    "receive_mat_name" => $datamaterialOld->receive_mat_name
                ]);
            }

            $transport_material_lot = MaterialLot::where('receive_material_id', '=', $data['id'])->get();
            foreach ($transport_material_lot as $value) {
                TransportPic::where('material_lot_id', '=', $value->id)->delete();
            }
            $delete_material_lot = MaterialLot::where('receive_material_id', '=', $data['id'])->delete();

            $data['transport_check'] = 1;
            $pic = null;

            if (isset($data['file_name']) && $data['file_name'] instanceof UploadedFile) {
                $pic = save_image($data['file_name'], 500, '/transport_pic/');
            } else if (isset($data['transport_old'])) {
                $pic = $data['transport_old'];
            }

            if ($data['lengthmaterial'] > 0) {
                foreach ($data['material'] as $material) {
                    $coa = "0";
                    if (isset($material['coa'])) {
                        $coa = save_image($material['coa'], 500, '/coa_material/');
                    };
                    $kg = $material['weight_kg'] * 1000;
                    $tons = $material['weight_ton'] * 1000000;
                    $total_weight = $kg + $tons + $material['weight_grams'];
                    $raw_mat = $this->materialRepository->find($material['receive_mat_name']);

                    $create_material_lot = MaterialLot::create([
                        "lot_no_pm" => null,
                        "lot" => $material['lot'],
                        "weight_grams" => $material['weight_grams'],
                        "weight_kg" => $material['weight_kg'],
                        "weight_ton" => $material['weight_ton'],
                        "weight_total" => $total_weight,
                        "mfg" => $material['mfg'],
                        "coa" => $coa,
                        "exp" => $material['exp'],
                        "action" => "1",
                        "quality_check" => 0,
                        "transport_check" => 0,
                        "company_id" => $material['company_id'],
                        "material_id" => 0,
                        "receive_material_id" => $data['id'],
                        "receive_mat_name" => $raw_mat->name,
                        "sender_vehicle_plate" => $data['sender_vehicle_plate'],
                        "transport_check" => $data['transport_check']
                        // "receive_mat_name" => $material['receive_mat_name'],
                    ]);

                    TransportPic::create([
                        'name' => $pic,
                        'created_by' => $data['user_id'],
                        'material_lot_id' => $create_material_lot->id,
                    ]);
                }
            }

            if ($data['lengthmaterialOld'] > 0) {
                foreach ($data['materialold'] as $materialold) {
                    $kg = $materialold['weight_kg'] * 1000;
                    $tons = $materialold['weight_ton'] * 1000000;
                    $total_weight = $kg + $tons + $materialold['weight_grams'];
                    // $raw_mat_old = $this->materialRepository->find($materialold['receive_mat_name']);

                    $create_material_lot_old = MaterialLot::create([
                        "lot_no_pm" => null,
                        "lot" => $materialold['lot'],
                        "weight_grams" => $materialold['weight_grams'],
                        "weight_kg" => $materialold['weight_kg'],
                        "weight_ton" => $materialold['weight_ton'],
                        "weight_total" => $total_weight,
                        "mfg" => $materialold['mfg'],
                        "coa" => $materialold['coa'],
                        "exp" => $materialold['exp'],
                        "action" => "1",
                        "quality_check" => 0,
                        "transport_check" => 0,
                        "company_id" => $materialold['company_id'],
                        "material_id" => 0,
                        "receive_material_id" => $data['id'],
                        // "receive_mat_name" => $raw_mat_old->name,
                        "sender_vehicle_plate" => $data['sender_vehicle_plate'],
                        "transport_check" => $data['transport_check'],
                        "receive_mat_name" => $materialold['receive_mat_name'],
                    ]);
                    TransportPic::create([
                        'name' => $pic,
                        'created_by' => $data['user_id'],
                        'material_lot_id' => $create_material_lot_old->id,
                    ]);
                }
            }
            $result['status'] = 'success';
            DB::commit();
        } catch (\Exception $e) {
            // $result['test'] = $transport_material_lot;
            $result['message'] = $e->getMessage();
            $result['trace'] = $e->getTraceAsString();
            DB::rollBack();
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'date' => $data['date'],
            'updated_by' => $data['user_id'],
            'recap' => $data['recap'],
        ];
        $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);

        return  $result;
    }


    public function findMaterialById(Request $request)
    {
        $data = $request->all();

        $material = $this->materialRepository->find($data['id']);
        return $material;
    }

    public function findCompanyById(Request $request)
    {
        $data = $request->all();
        $company = $this->conmpanyRepository->find($data['id']);
        return $company;
    }

    public function listViewEditReceiveMaterial(Request $request)
    {
        $postData = $request->all();
        $receivematerial = $this->receiveMaterialRepository->find($postData['id']);
        return $receivematerial;
    }

    public function listMaterialLot(Request $request)
    {
        $postData = $request->all();
        $id = $postData['id'];

        $records = $this->materialLotRepository->getAllMaterialLot($id);
        foreach ($records as $record) {
            $company = $this->conmpanyRepository->find($record->company_id);
            $transport = $this->transportPicRepository->getTransportId($record->id);
            $record->companies = $company;
        }

        return [
            "aaData" => $records,
            "aaDataT" => $transport,
        ];
    }

    protected function validateConfirmTransportCheck(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "sender_vehicle_plate" => ["required"],
            "transport_check_detail" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function confirmTransportCheck(Request $request)
    {
        $data = $request->all();
        $data['transport_check'] = 1;
        $id = $data['id'];
        $files = isset($data['file_name']) ? $data['file_name'] : null;
        if (isset($files)) {
            foreach ($files as $file) {
                $pic = save_image($file, 500, '/transport_pic/');
                TransportPic::create([
                    'name' => $pic,
                    'created_by' => $data['user_id'],
                    'material_lot_id' => $id,
                ]);
            }
        };

        $update_transport_check = $this->materialLotRepository->update($request->id, $data);
        return $update_transport_check;
    }

    public function historyReceiveMaterial(Request $request)
    {
        $records = $this->historyReceiveMaterialRepository->historyReceiveMaterial($request['id']);
        return [
            "aaData" => $records,
        ];
    }

    public function getTemplateDetail(Request $request)
    {
        $template_detail = $this->receiveMaterialRepository->getTemplateDetailByTemplateID($request['id']);
        return $template_detail;
    }

    public function listCheckReceiveMaterialLotNoPm(Request $request)
    {
        $postData = $request->all();
        $paper_status = 2;
        $inspect_ready = 1;
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "company_id" => $request->company_id,
            "rowperpage" => $rowperpage
        ];
        $totalRecordswithFilter = $totalRecords = $this->receiveMaterialRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveMaterialRepository->getAllReceiveMaterials($param, $searchValue, $paper_status, $inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveMaterialRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function editInspect_ready(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'inspect_ready' => 1,
        ];
        $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);
        return $update_receive_material;
    }

    public function stepBackToReceive(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'inspect_ready' => 0,
        ];
        $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_material;
    }

    public function stepToLotNoPM(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 2,
            'updated_by' => $data['user_id'],
        ];
        $update_receive_material2 = $this->receiveMaterialRepository->update($data['id'], $data_update);
        return $update_receive_material2;
    }

    public function stepBackToInspect(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'inspect_ready' => 1,
        ];
        $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_material;
    }

    public function stepToPending(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 4,
        ];
        $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_material;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 4,
        ];
        $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_material;
    }

    public function listMasterReceiveMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 4;
        $inspect_ready = 1;
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "company_id" => $request->company_id,
            "rowperpage" => $rowperpage
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receiveMaterialRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveMaterialRepository->getAllReceiveMaterials($param, $searchValue, $paper_status, $inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveMaterialRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function rejectReceiveMaterial(Request $request)
    {
        $data = $request->all();
        $status = 'false';
        if ($data['reject_detail'] != null) {
            $data_update = [
                'reject_status' => 1,
                'reject_detail' => $data['reject_detail'],
                'paper_status' => 3,
            ];
            $update_receive_material = $this->receiveMaterialRepository->update($data['id'], $data_update);
            $status = 'true';
        }
        return $status;
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 0,
        ];
        $update = $this->receiveMaterialRepository->update($data['id'], $data_update);
        return $update;
    }
}
