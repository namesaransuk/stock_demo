<?php

namespace App\Http\Controllers\APIs;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\HistoryMaterialCutReturn;
use App\Models\HistoryRequsitionMaterial;
use App\Models\MaterialCutReturn;
use App\Models\RequsitionMaterial;
use App\Repositories\HistoryRequsitionMaterialInterface;
use App\Repositories\MaterialCutReturnInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\MaterialInterface;

use App\Repositories\RequsitionMaterialInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequsitionMaterialController extends Controller
{
    private $materialRepository;
    private $materialLotRepository;
    private $requsitionMaterialRepository;
    private $historyRequsitionMaterialRepository;
    private $materialcutreturnRepository;
    public function __construct(MaterialInterface $materialRepository, MaterialLotInterface $materialLotRepository, RequsitionMaterialInterface $requsitionMaterialRepository, MaterialCutReturnInterface $materialcutreturnRepository, HistoryRequsitionMaterialInterface $historyRequsitionMaterialRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->materialLotRepository = $materialLotRepository;
        $this->requsitionMaterialRepository = $requsitionMaterialRepository;
        $this->materialcutreturnRepository = $materialcutreturnRepository;
        $this->historyRequsitionMaterialRepository = $historyRequsitionMaterialRepository;
    }

    public function getMaterialBalance(Request $request)
    {
        // DB::enableQueryLog();

        $data = $request->all();
        $arr_ = [];
        $material_total = $this->materialRepository->tradeNameAndRemain($data);
        // $laQuery = DB::getQueryLog();

        foreach ($material_total as $remain) {
            $value_ = DB::table('material_lots')
                ->selectRaw('getBalanceMaterialStockByMaterialID("' . $remain->id . '") as remain')
                ->first();
            $param = [
                "itemCode" => $remain->trade_name,
                "itemValue" => $value_->remain
            ];
            array_push($arr_, $param);
        }

        return $arr_;
    }

    // public function getMaterialLotAndMaterialsCut(Request $request)
    // {
    //     $data = $request->all();
    //     foreach ($data as $material_id) {
    //         $material_id = $material_id['material_id'];
    //         $material_total = $this->materialRepository->tradeNameAndRemain($material_id);
    //         foreach ($material_total as $remain) {
    //             $remain->remain = $this->materialLotRepository->sumRemain($material_id);
    //         }
    //     }
    //     foreach ($material_lots as $material_lot) {
    //         foreach ($material_lot as $id) {
    //             $material_id = $id->id;
    //             $material_cut_return[] = $this->materialcutreturnRepository->getCutReturnById($material_id);
    //         }
    //     }

    //     return [
    //         "material_total" => $material_total,
    //         "material_lots" => $material_lots,
    //         "material_cut_return" => $material_cut_return,
    //     ];
    // }

    public function list(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $ins_cut = 0;
        $ins_return = 0;

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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listInspectCut(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $ins_cut = 1;
        $ins_return = 0;

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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function getMaterialLotByMaterialsId(Request $request)
    {
        $data = $request->all();
        $material_lots = $this->materialLotRepository->getLotRemainById($data['material_id']);
        $material_cut_return = $this->materialcutreturnRepository->all();
        return [
            "material_lots" => $material_lots,
            "material_cut_return" => $material_cut_return,
        ];
    }

    public function createRequsitionMaterial(Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];
        $create_requsition_material = RequsitionMaterial::create([
            "paper_no" => $data['paper_no'],
            "edit_times" => 0,
            "date" => $data['date'],
            "history_flag" => "1",
            "created_by" => $data['user_id'],
            "updated_by" => $data['user_id'],
            "product_name" => $data['product_name'],
            "production_user_id" => $data['user_id'],
            "procurement_user_id" => 0,
            'company_id' => $data['company_id'],
            "stock_user_id" => 0
        ]);

        foreach ($data['material'] as $key => $value) {
            $create_material_cut_returns = MaterialCutReturn::create([
                "datetime" => $value['date'],
                "weight" => $value['weight'],
                "action" => 1,
                "created_by" => $user_id,
                "updated_by" => $user_id,
                "requsition_material_id" => $create_requsition_material->id,
                "material_lot_id" => $value['material_lot_id'],
            ]);
        };
        // dd($data);
        return $create_requsition_material;
    }

    public function getRequsitionMaterialLotByID(Request $request)
    {
        $data = $request->all();
        // getAllMaterialRequsitionLot
        $material_cut_returns = $this->materialcutreturnRepository->getAllMaterialRequsitionLot($data['id']);

        return $material_cut_returns;
    }

    public function editRequsitionMaterial(Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];
        // dd($data['product_name']);
        $newedit_times = $data['edit_times'] + 1;
        $data_recap = $data['recap_old'];
        if ($data['recap_old'] === null) {
            $data_recap = " ";
        }
        $create_requsition_material_history = HistoryRequsitionMaterial::create([
            "paper_no" => $data['paper_no'],
            "edit_times" => $data['edit_times'],
            "date" => $data['date'],
            "created_by" => $data['created_by'],
            "updated_by" => $data['updated_by'],
            "product_name" => $data['product_name'],
            "requsition_material_id" => $data['id'],
            "production_user_id" => $data['production_user_id'],
            "procurement_user_id" => $data['procurement_user_id'],
            "stock_user_id" => $data['stock_user_id'],
            'company_id' => $data['company_id'],
            "recap" => $data_recap,
        ]);

        foreach (json_decode($data['materialOld']) as $key => $value) {
            $create_material_cut_returns_history = HistoryMaterialCutReturn::create([
                "datetime" => $value->datetime,
                "weight" => $value->weight,
                "action" => $value->action,
                "created_by" => $value->created_by,
                "updated_by" => $value->updated_by,
                "requsition_material_id" => $value->requsition_material_id,
                "material_lot_id" => $value->material_lot_id,
                "history_requsition_material_id" => $create_requsition_material_history->id,
            ]);
        };

        $delete_material_cut_return = DB::table('material_cut_returns')->where('requsition_material_id', '=', $data['id'])->delete();

        if ($data['lengthmaterialOld'] > 0) {

            foreach ($data['materialold'] as $materialold) {
                // dd($materialold);
                $create_material_cut_old = MaterialCutReturn::create([
                    "datetime" => $materialold['date'],
                    "weight" => $materialold['weight'],
                    "created_by" => $data['created_by'],
                    "updated_by" => $user_id,
                    "action" => 1,
                    "requsition_material_id" => $data['id'],
                    "material_lot_id" => $materialold['material_lot_id'],
                ]);
            };
        }

        if ($data['lengthmaterial'] > 0) {
            foreach ($data['material'] as $material) {
                $create_material_cut = MaterialCutReturn::create([
                    "datetime" => $material['date'],
                    "weight" => $material['weight'],
                    "created_by" => $data['user_id'],
                    "updated_by" => $data['user_id'],
                    "action" => 1,
                    "requsition_material_id" => $data['id'],
                    "material_lot_id" => $material['material_lot_id'],
                ]);
            };
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'date' => $data['date'],
            'updated_by' => $data['user_id'],
            'recap' => $data['recap']
        ];

        $update_requsition_material = $this->requsitionMaterialRepository->update($data['id'], $data_update);

        return $update_requsition_material;
    }

    public function getHistoryRequsitionMaterialByID(Request $request)
    {
        $data = $request->all();

        $history_requsition_material = $this->historyRequsitionMaterialRepository->historyRequsitionMaterial($data['id']);
        return $history_requsition_material;
    }

    public function listReturnMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 4;
        $ins_cut = 1;
        $ins_return = 0;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);
        $records = $this->getWeightReturn($records);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    private function getWeightReturn($records)
    {
        foreach ($records as $requisitionMaterial) {
            $materialCuts  = $requisitionMaterial->materialCutReturns->filter(function ($materialCutReturn) {
                $materialCutReturn->weight_r = -1;
                return $materialCutReturn->action == 1;
            });
            $materialReturns  = $requisitionMaterial->materialCutReturns->filter(function ($materialCutReturn) {
                return $materialCutReturn->action == 2;
            });
            foreach ($materialReturns as $materialReturn) {
                if ($obj = $materialCuts->firstWhere('material_lot_id', $materialReturn->material_lot_id)) {
                    $obj->weight_r = $materialReturn->weight;
                }
            }
            $requisitionMaterial->materialCutReturns  = $materialCuts;
        }
        return $records;
    }

    public function listInspectReturn(Request $request)
    {
        $postData = $request->all();
        $paper_status = 4;
        $ins_cut = 1;
        $ins_return = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);
        $records = $this->getWeightReturn($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function createReturnMaterial(Request $request)
    {
        $data = $request->all();
        $today = date("Y-m-d H:i:s");
        foreach ($data['materialold'] as $key => $value) {
            // dd($value['total_weight']);
            $create_material_return = MaterialCutReturn::create([
                "datetime" => $today,
                "weight" => $value['total_weight'],
                "action" => 2,
                "created_by" => $data['user_id'],
                "updated_by" => $data['user_id'],
                "requsition_material_id" => $data['id'],
                "material_lot_id" => $value['material_lot_id'],
            ]);
        }
        // $material_cut_return = $this->materialcutreturnRepository->find($data['id']);
        // dd($material_cut_return->weight);
        // $total_weight = $data['weight'] * 1000;
        return $create_material_return;
    }

    public function listPendingRequsitionMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 3;
        $ins_cut = 1;
        $ins_return = 0;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPendingReturnRequsitionMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 5;
        $ins_cut = 1;
        $ins_return = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);
        $records = $this->getWeightReturn($records);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listInspectReturnMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 4;
        $ins_cut = 1;
        $ins_return = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listHistoryRequsitionMaterial(Request $request)
    {
        $postData = $request->all();
        $paper_status = 6;
        $ins_cut = 1;
        $ins_return = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionMaterialRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionMaterialRepository->getAllRequsitionMaterial($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionMaterialRepository->paginate($param, $paper_status, $ins_cut, $ins_return);
        $records = $this->getWeightReturn($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function stepToInspectCut(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_cut' => 1,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepBackToCut(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_cut' => 0,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToPendingCut(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 4,
            'procurement_user_id' => $data['user_id'],
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToPendingReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 6,
            'stock_user_id' => $data['user_id'],
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 4,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToInspectReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_return' => 1,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepBackToReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_return' => 0,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 6,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 0,
        ];
        $update = $this->requsitionMaterialRepository->update($data['id'], $data_update);
        return $update;
    }
}
