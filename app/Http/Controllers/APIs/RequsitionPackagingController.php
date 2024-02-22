<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\HistoryPackagingCutReturn;
use App\Models\HistoryRequsitionPackaging;
use App\Models\PackagingCutReturn;
use App\Models\RequsitionPackaging;
use App\Repositories\HistoryRequsitionPackagingInterface;
use App\Repositories\PackagingCutReturnInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingLotInterface;
use App\Repositories\RequsitionPackagingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequsitionPackagingController extends Controller
{
    private $packagingRepository;
    private $packagingLotRepository;
    private $requsitionPackagingRepository;
    private $historyRequsitionPackagingRepository;
    private $packagingCutReturnRepository;
    public function __construct(PackagingInterface $packagingRepository, RequsitionPackagingInterface $requsitionPackagingRepository, HistoryRequsitionPackagingInterface $historyRequsitionPackagingRepository, PackagingCutReturnInterface $packagingCutReturnRepository, PackagingLotInterface $packagingLotRepository)
    {
        $this->packagingRepository = $packagingRepository;
        $this->requsitionPackagingRepository = $requsitionPackagingRepository;
        $this->historyRequsitionPackagingRepository = $historyRequsitionPackagingRepository;
        $this->packagingCutReturnRepository = $packagingCutReturnRepository;
        $this->packagingLotRepository = $packagingLotRepository;
    }

    public function getPackagingLotAndPackagingCut(Request $request)
    {
        $data = $request->all();
        foreach ($data as $packaging_id) {
            $packaging_id = $packaging_id['packaging_id'];
            $packaging_lots[] = $this->packagingLotRepository->getLotRemainById($packaging_id);
        }
        foreach ($packaging_lots as $packaging_lot) {
            foreach ($packaging_lot as $id) {
                $packaging_id = $id->id;
                $packaging_cut_return[] = $this->packagingCutReturnRepository->getCutReturnById($packaging_id);
            }
        }
        return [
            "packaging_lots" => $packaging_lots,
            "packaging_cut_return" => $packaging_cut_return,
        ];
    }

    public function returnClaimPackaging(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'action' => 4,
        ];
        $update = $this->packagingCutReturnRepository->update($data['id'], $data_update);

        return $update;
    }

    public function cancelClaimPackaging(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'action' => 1,
        ];
        $update = $this->packagingCutReturnRepository->update($data['id'], $data_update);

        return $update;
    }


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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_return, $ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_return, $ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_return, $ins_cut);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }


    public function getPackagingLotByPackagingId(Request $request)
    {
        $data = $request->all();
        $packaging_lots = $this->packagingLotRepository->getLotRemainById($data['packaging_id']);
        $packaging_cut_return = $this->packagingCutReturnRepository->all();
        return [
            "packaging_lots" => $packaging_lots,
            "packaging_cut_return" => $packaging_cut_return,

        ];
    }

    public function createRequsitionPackaging(Request $request)
    {
        $data = $request->all();
        //    dd($data);

        $create_requsition_packaging = RequsitionPackaging::create([
            "paper_no" => $data['paper_no'],
            "edit_times" => 0,
            "date" => $data['date'],
            "paper_status" => "1",
            "created_by" => $data['user_id'],
            "updated_by" => $data['user_id'],
            "product_name" => $data['product_name'],
            "production_user_id" => $data['user_id'],
            "procurement_user_id" => 0,
            'company_id' => $data['company_id'],
            "stock_user_id" => 0
        ]);

        foreach ($data['packaging'] as $key => $value) {
            $create_packaging_cut_return = PackagingCutReturn::create([
                "datetime" => $value['date'],
                "qty" => $value['qty'],
                "action" => 1,
                "created_by" => $data['user_id'],
                "updated_by" => $data['user_id'],
                "requsition_packaging_id" => $create_requsition_packaging->id,
                "packaging_lot_id" => $value['packaging_lot_id'],
            ]);
        }

        return $create_requsition_packaging;
    }

    public function getRequsitionPackagingLotByID(Request $request)
    {
        $data = $request->all();
        // getAllPackagingRequsitionLot
        $packaging_cut_returns = $this->packagingCutReturnRepository->getAllPackagingRequsitionLot($data['id']);

        return $packaging_cut_returns;
    }

    public function editRequsitionPackaging(Request $request)
    {
        $data = $request->all();
        $newedit_times = $data['edit_times'] + 1;
        $data_recap = $data['recap_old'];
        if ($data['recap_old'] === null) {
            $data_recap = " ";
        }
        $create_requsition_packaging_history = HistoryRequsitionPackaging::create([
            "paper_no" => $data['paper_no'],
            "edit_times" => $data['edit_times'],
            "date" => $data['date'],
            "paper_status" => $data['paper_status'],
            "created_by" => $data['created_by'],
            "updated_by" => $data['updated_by'],
            "product_name" => $data['product_name'],
            "requsition_packaging_id" => $data['id'],
            "production_user_id" => $data['production_user_id'],
            "procurement_user_id" => $data['procurement_user_id'],
            "stock_user_id" => $data['stock_user_id'],
            'company_id' => $data['company_id'],
            "recap" => $data_recap
        ]);

        foreach (json_decode($data['packagingOld']) as $key => $value) {
            $create_packaging_cut_returns_history = HistoryPackagingCutReturn::create([
                "datetime" => $value->datetime,
                "qty" => $value->qty,
                "action" => $value->action,
                "created_by" => $data['created_by'],
                "updated_by" => $data['updated_by'],
                "requsition_packaging_id" => $value->requsition_packaging_id,
                "packaging_lot_id" => $value->packaging_lot_id,
                "history_requsition_packaging_id" => $create_requsition_packaging_history->id,
            ]);
        };

        $delete_packaging_cut_return = DB::table('packaging_cut_returns')->where('requsition_packaging_id', '=', $data['id'])->delete();

        if ($data['lengthpackagingOld'] > 0) {

            foreach ($data['packagingold'] as $packagingold) {
                //    dd($packagingold);
                $create_packaging_cut_old = packagingCutReturn::create([
                    "datetime" => $packagingold['date'],
                    "qty" => $packagingold['qty'],
                    "action" => 1,
                    "created_by" => $data['created_by'],
                    "updated_by" => $data['user_id'],
                    "requsition_packaging_id" => $data['id'],
                    "packaging_lot_id" => $packagingold['packaging_lot_id'],
                ]);
            };
        }

        if ($data['lengthpackaging'] > 0) {
            foreach ($data['packaging'] as $packaging) {
                $create_packaging_cut = packagingCutReturn::create([
                    "datetime" => $packaging['date'],
                    "qty" => $packaging['qty'],
                    "action" => 1,
                    "created_by" => $data['user_id'],
                    "updated_by" => $data['user_id'],
                    "requsition_packaging_id" => $data['id'],
                    "packaging_lot_id" => $packaging['packaging_lot_id'],
                ]);
            };
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'date' => $data['date'],
            "updated_by" => $data['user_id'],
            "recap" => $data['recap']
        ];

        $update_requsition_packaging = $this->requsitionPackagingRepository->update($data['id'], $data_update);

        return $update_requsition_packaging;
    }

    public function getHistoryRequsitionPackagingByID(Request $request)
    {
        $data = $request->all();

        $history_requsition_packaging = $this->historyRequsitionPackagingRepository->historyRequsitionPackaging($data['id']);
        return $history_requsition_packaging;
    }

    public function createReturnPackaging(Request $request)
    {
        $data = $request->all();
        $today = date("Y-m-d H:i:s");
        foreach ($data['packagingold'] as $key => $value) {

            $create_packaging_cut = packagingCutReturn::create([
                "datetime" => $today,
                "qty" => $value['met_good'],
                "action" => 2,
                "created_by" => $data['user_id'],
                "updated_by" => $data['user_id'],
                "requsition_packaging_id" => $data['id'],
                "packaging_lot_id" => $value['packaging_lot_id'],

                "use_qty" => $value['use_qty'],
                "met_good" => $value['met_good'],
                "met_waste" => $value['met_waste'],
                "met_claim" => $value['met_claim'],
                "met_destroy" => $value['met_destroy'],

            ]);

            if ($value['met_claim'] > 0) {
                $create_packaging_cut = packagingCutReturn::create([
                    "datetime" => $today,
                    "qty" => $value['met_claim'],
                    "action" => 3,
                    "created_by" => $data['user_id'],
                    "updated_by" => $data['user_id'],
                    "requsition_packaging_id" => $data['id'],
                    "packaging_lot_id" => $value['packaging_lot_id'],
                ]);
            }
        }
        return $create_packaging_cut;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_cut, $ins_return);
        $records = $this->getqtyReturn($records);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPendingRequsitionPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_return, $ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_return, $ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_return, $ins_cut);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPendingReturnRequsitionPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_cut, $ins_return);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_cut, $ins_return)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_cut, $ins_return);
        $records = $this->getqtyReturn($records);

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
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepBackToCut(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_cut' => 0,
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToPending(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 3,
            'procurement_user_id' => $data['user_id'],
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToPendingReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 5,
            'stock_user_id' => $data['user_id'],
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 4,
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToInspectReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_return' => 1,
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepBackToReturn(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'ins_return' => 0,
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 6,
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }



    public function listInspectRequsitionPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_return, $ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_return, $ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_return, $ins_cut);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listReturnPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_return, $ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_return, $ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_return, $ins_cut);
        $records = $this->getqtyReturn($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    private function getqtyReturn($records)
    {
        foreach ($records as $requsitionpackaging) {
            $packagingCut  = $requsitionpackaging->packagingCutReturns->filter(function ($packagingCutReturn) {
                $packagingCutReturn->qty_r = -1;
                return $packagingCutReturn->action == 1;
            });
            $packagingReturns  = $requsitionpackaging->packagingCutReturns->filter(function ($packagingCutReturn) {
                return $packagingCutReturn->action == 2;
            });
            foreach ($packagingReturns as $packagingReturn) {
                if ($obj = $packagingCut->firstWhere('packaging_lot_id', $packagingReturn->packaging_lot_id)) {
                    $obj->qty_r = $packagingReturn->qty;
                    $obj->met_good_re = $packagingReturn->met_good;
                    $obj->met_waste_re = $packagingReturn->met_waste;
                    $obj->met_claim_re = $packagingReturn->met_claim;
                    $obj->met_destroy_re = $packagingReturn->met_destroy;
                }
            }
            $requsitionpackaging->packagingCutReturns  = $packagingCut;
        }
        return $records;
    }

    public function listClaimPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->countClaim($param);


        // if (strlen($searchValue) > 0) {
        //     $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param,$searchValue,$paper_status,$ins_return,$ins_cut)->count();
        // }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginateClaim($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listInspectReturnPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_return, $ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_return, $ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_return, $ins_cut);
        $records = $this->getqtyReturn($records);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listHistoryReturnPackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionPackagingRepository->count($param, $paper_status, $ins_return, $ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionPackagingRepository->getAllRequsitionPackaging($param, $searchValue, $paper_status, $ins_return, $ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionPackagingRepository->paginate($param, $paper_status, $ins_return, $ins_cut);
        $records = $this->getqtyReturn($records);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 0,
        ];
        $update = $this->requsitionPackagingRepository->update($data['id'], $data_update);
        return $update;
    }
}
