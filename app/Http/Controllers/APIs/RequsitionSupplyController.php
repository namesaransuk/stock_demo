<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\HistoryRequsitionSupply;
use App\Models\HistorySupplyCut;
use App\Models\RequsitionSupply;
use App\Models\SupplyCut;
use App\Repositories\HistoryRequsitionSupplyInterface;
use App\Repositories\RequsitionSupplyInterface;
use App\Repositories\SupplyCutInterface;
use App\Repositories\SupplyInterface;
use App\Repositories\SupplyLotInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequsitionSupplyController extends Controller
{
    private $supplyRepository;
    private $supplyLotRepository;
    private $supplyCutRepository;
    private $requsitionSupplyRepository;
    private $historyRequsitionSupplyRepository;

    public function __construct(SupplyInterface $supplyRepository,RequsitionSupplyInterface $requsitionSupplyRepository,HistoryRequsitionSupplyInterface $historyRequsitionSupplyRepository,SupplyLotInterface $supplyLotRepository,SupplyCutInterface $supplyCutRepository)
    {
        $this->supplyRepository = $supplyRepository;
        $this->requsitionSupplyRepository = $requsitionSupplyRepository;
        $this->historyRequsitionSupplyRepository = $historyRequsitionSupplyRepository;
        $this->supplyLotRepository = $supplyLotRepository;
        $this->supplyCutRepository = $supplyCutRepository;
    }

    public function getSupplyLotAndSupplyCut(Request $request)
    {
        $data = $request->all();
        foreach ($data as $supply_id) {
            $supply_id = $supply_id['supply_id'];
            $supply_lots[] = $this->supplyLotRepository->getLotRemainById($supply_id);
        }
        foreach ($supply_lots as $supply_lot) {
            foreach ($supply_lot as $id) {
                $supply_id = $id->id;
                $supply_cut[] = $this->supplyCutRepository->getCutReturnById($supply_id);
            }
        }
        return [
            "supply_lots" => $supply_lots,
            "supply_cut" => $supply_cut,
        ];
    }

    public function list(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionSupplyRepository->count($param,$paper_status);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionSupplyRepository->getAllRequsitionSupply($param,$searchValue,$paper_status)->count();
        }


        // Fetch records
        $records = $this->requsitionSupplyRepository->paginate($param,$paper_status);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listHistory(Request $request)
    {
        $postData = $request->all();
        $paper_status = 3;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionSupplyRepository->count($param,$paper_status);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionSupplyRepository->getAllRequsitionSupply($param,$searchValue,$paper_status)->count();
        }


        // Fetch records
        $records = $this->requsitionSupplyRepository->paginate($param,$paper_status);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 3,
        ];
        $update = $this->requsitionSupplyRepository->update($data['id'],$data_update);
        return $update;
    }

    public function getSupplyLotBySupplyId(Request $request)
    {
        $data = $request->all();
        $supply_lots = $this->supplyLotRepository->getLotRemainById($data['supply_id']);
        $supply_cut = $this->supplyCutRepository->all();
        return [
            "supply_lots" => $supply_lots,
            "supply_cut" => $supply_cut,
        ];
    }

    public function createRequsitionSupply(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $user_id = $data['user_id'];
            DB::beginTransaction();
            $create_requsition_supply = null;
        try {
            $create_requsition_supply = RequsitionSupply::create([
                "paper_no" => $data['paper_no'],
                "paper_status" => 3,
                "edit_times" => 0,
                "date" => $data['date'],
                "created_by" => $user_id,
                "updated_by" => $user_id,
                "stock_user_id" => $user_id,
                "detail" => $data['detail'],
                'company_id' => $data['company_id'],
        ]);

            foreach ($data['supply'] as $key => $value) {
                $create_supply_cuts = SupplyCut::create([
                    "action" => 1,
                    "qty" => $value['qty'],
                    "created_by" => $user_id,
                    "updated_by" => $user_id,
                    "supply_lot_id" => $value['supply_lot_id'],
                    "requsition_supply_id" => $create_requsition_supply->id,
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }

        return $create_requsition_supply;
    }

    public function getRequsitionSupplyLotByID(Request $request)
    {
        $data = $request->all();
        $supply_cuts = $this->supplyCutRepository->getAllSupplyRequsitionLot($data['id']);
        return $supply_cuts;
    }

    public function editRequsitionSupply(Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];
        // dd($data['product_name']);
        $newedit_times = $data['edit_times'] + 1;
        if(!$data['recap_old']){
            $recap = '';
        }
        else{
            $recap = $data['recap_old'];
        }
        $create_requsition_supply_history = HistoryRequsitionSupply::create([
            "paper_no" => $data['paper_no'],
            "edit_times" => $data['edit_times'],
            "date" => $data['date'],
            "created_by" => $data['created_by'],
            "updated_by" => $data['updated_by'],
            "stock_user_id" => $data['stock_user_id'],
            "detail" => $data['detail'],
            "recap" => $recap,
            "requsition_supply_id" => $data['id'],
            'company_id' => $data['company_id'],
        ]);

        foreach (json_decode($data['supplyOld']) as $key => $value) {
           $create_supply_cut_history = HistorySupplyCut::create([
            "datetime" => $value->datetime,
            "action" => $value->action,
            "qty" => $value->qty,
            "created_by" => $value->created_by,
            "updated_by" => $value->updated_by,
            "supply_lot_id" => $value->supply_lot_id,
            "requsition_supply_id" => $value->requsition_supply_id,
            "history_requsition_supply_id" => $create_requsition_supply_history->id,
           ]);
        };

        $delete_supply_cut_return = DB::table('supply_cuts')->where('requsition_supply_id', '=', $data['id'])->delete();

        if ($data['lengthsupplyOld'] > 0) {

            foreach ($data['supplyold'] as $supplyold) {
               $create_supply_cut_old = SupplyCut::create([
                "action" => 1,
                "qty" => $supplyold['qty'],
                "created_by" => $data['created_by'],
                "updated_by" => $user_id,
                "supply_lot_id" => $supplyold['supply_lot_id'],
                "requsition_supply_id" => $data['id'],
               ]);
            };
        }

        if ($data['lengthsupply']>0) {
            foreach ($data['supply'] as $supply) {
               $create_supply_cut = SupplyCut::create([
                "action" => 1,
                "qty" => $supply['qty'],
                "created_by" => $data['created_by'],
                "updated_by" => $user_id,
                "supply_lot_id" => $supply['supply_lot_id'],
                "requsition_supply_id" => $data['id'],
               ]);
            };
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'date' => $data['date'],
            'updated_by' => $data['user_id'],
            'recap' => $data['recap']
        ];

        $update_requsition_supply = $this->requsitionSupplyRepository->update($data['id'],$data_update);

        return $update_requsition_supply;
    }

    public function historyRequsitionSupply(Request $request)
    {
        $records = $this->historyRequsitionSupplyRepository->historyRequsitionSupply($request['id']);
        return [
            "aaData" => $records,
        ];
    }

    public function delete(Request $request)
    {
        $data = $request->all();
            $data_update = [
                'paper_status' => 0,
            ];
            $update = $this->requsitionSupplyRepository->update($data['id'],$data_update);
        return $update;
    }
}
