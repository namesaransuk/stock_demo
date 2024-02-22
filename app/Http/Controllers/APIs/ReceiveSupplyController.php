<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\HistoryReceiveSupply;
use App\Models\HistorySupplyLot;
use App\Models\ReceiveSupply;
use App\Models\SupplyLot;
use App\Repositories\HistoryReceiveSupplyInterface;
use App\Repositories\ReceiveSupplyInterface;
use App\Repositories\SupplyLotInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiveSupplyController extends Controller
{
    private $receiveSupplyRepository;
    private $historyReceiveSupplyRepository;
    private $supplyLotRepository;
    public function __construct(ReceiveSupplyInterface $receiveSupplyRepository, SupplyLotInterface $supplyLotRepository,HistoryReceiveSupplyInterface $historyReceiveSupplyRepository)
    {
        $this->receiveSupplyRepository = $receiveSupplyRepository;
        $this->supplyLotRepository = $supplyLotRepository;
        $this->historyReceiveSupplyRepository = $historyReceiveSupplyRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->receiveSupplyRepository->count($param,$paper_status);

        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveSupplyRepository->getAllReceiveSupplies($param,$searchValue,$paper_status)->count();
        }

        // Fetch records
        $records = $this->receiveSupplyRepository->paginate($param,$paper_status);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPendingReceiveSupply(Request $request)
    {
        $postData = $request->all();
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receiveSupplyRepository->countPending();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveSupplyRepository->getAllPendingReceiveSupplies($searchValue)->count();
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
        $records = $this->receiveSupplyRepository->paginatePendingListReceiveSupplies($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listMasterReceiveSupply(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->receiveSupplyRepository->count($param,$paper_status);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveSupplyRepository->getAllReceiveSupplies($param,$searchValue,$paper_status)->count();
        }

        // Fetch records
        $records = $this->receiveSupplyRepository->paginate($param,$paper_status);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function stepToPending(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 2,
        ];
        $update_receive_supply = $this->receiveSupplyRepository->update($data['id'],$data_update);
        // dd($data);
        return $update_receive_supply;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 3,
        ];

        $update_receive_supply = $this->receiveSupplyRepository->update($data['id'],$data_update);
        $update_supply_lot = $this->supplyLotRepository->updateActionByReceiveID($data['id']);
        // dd($data);
        return $update_receive_supply;
    }

    public function stepBackToReceive(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
        ];
        $update_receive_supply = $this->receiveSupplyRepository->update($data['id'],$data_update);
        // dd($data);
        return $update_receive_supply;
    }

    public function listViewEditReceiveSupply(Request $request)
    {
        $postData = $request->all();
        $receivesupply = $this->receiveSupplyRepository->find($postData['id']);
        return $receivesupply;
    }

    public function listSupplyLot(Request $request)
    {
        $postData = $request->all();
        $id = $postData['id'];
            $records = $this->supplyLotRepository->getAllSupplyLot($id);

            return [
                "aaData" => $records,
            ];
    }

    public function createReceiveSupply(Request $request)
    {
        DB::beginTransaction();
        $create_receive_supply = null;
        try {
        $data = $request->all();
        $create_receive_supply = ReceiveSupply::create([
            'paper_no' => $data['paper_no'],
            'edit_times' => 0,
            'date' => $data['date'],
            'created_by' => $data['user_id'],
            'updated_by' => $data['user_id'],
            'stock_user_id' => $data['user_id'],
            'brand_vendor_id' => $data['brand_vendor_id'],
            'company_id' => $data['company_id'],
        ]);

        foreach ($data['supply'] as $supply) {
           $create_supply_lot = SupplyLot::create([
                'lot' => $supply['lot'],
                'qty' => $supply['qty'],
                'mfg' => $supply['mfg'],
                'exp' => $supply['exp'],
                'action' => "1",
                'company_id' => $supply['company_id'],
                'receive_supply_id' => $create_receive_supply->id,
                'supply_id' =>$supply['supply_id'],
           ]);
        }
        DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
        }

        return $create_receive_supply;
    }


    public function editReceiveSupply(Request $request)
    {

        $data = $request->all();
        if(!$data['recapold']){
            $recap = '';
        }
        else{
            $recap = $data['recapold'];
        }
        $newedit_times = $data['edit_times'] + 1;
        $create_history_receive_supply = HistoryReceiveSupply::create([
            'paper_no' => $data['paper_no'],
            'paper_status' => $data['paper_status'],
            'edit_times' => $data['edit_times'],
            'date' => $data['date'],
            'created_by' => $data['created_by'],
            'updated_by' => $data['updated_by'],
            'stock_user_id' => $data['stock_user_id'],
            'recap' => $recap,
            'brand_vendor_id' => $data['brand_vendor_id'],
            'receive_supply_id' => $data['id'],
            'company_id' => $data['company_id'],
        ]);

        foreach(json_decode($data['supplyOld']) as $supplyOld){
            // dd($supplyOld->company_id);
            $create_history_supply = HistorySupplyLot::create([
                'lot' => $supplyOld->lot,
                'qty' => $supplyOld->qty,
                'mfg' => $supplyOld->mfg,
                'exp' => $supplyOld->exp,
                'action' => $supplyOld->action,
                'company_id' => $supplyOld->company_id,
                'receive_supply_id' => $supplyOld->receive_supply_id,
                'supply_id' => $supplyOld->supply_id,
                'history_receive_supply_id' => $create_history_receive_supply->id,
            ]);
        }
        $delete_supply_lot = DB::table('supply_lots')->where('receive_supply_id', '=', $data['id'])->delete();
        if ($data['lengthsupplyOld'] > 0) {
            foreach ($data['supplyold'] as $supplyold) {
                $create_supply_lot_old = SupplyLot::create([
                     'lot' => $supplyold['lot'],
                     'qty' => $supplyold['qty'],
                     'mfg' => $supplyold['mfg'],
                     'exp' => $supplyold['exp'],
                     'action' => "1",
                     'company_id' => $supplyold['company_id'],
                     'supply_id' => $supplyold['supply_id'],
                     'receive_supply_id' => $data['id'],
                ]);
             }
        }

        if ($data['lengthsupply'] > 0) {
            foreach ($data['supply'] as $supply) {
                $create_supply_lot = SupplyLot::create([
                     'lot' => $supply['lot'],
                     'qty' => $supply['qty'],
                     'mfg' => $supply['mfg'],
                     'exp' => $supply['exp'],
                     'action' => "1",
                     'company_id' => $supply['company_id'],
                     'supply_id' => $supply['supply_id'],
                     'receive_supply_id' => $data['id']
                ]);
             }
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'updated_by' => $data['user_id'],
            'date' => $data['date'],
            'recap' => $data['recap'],
        ];

        $update_receive_supply = $this->receiveSupplyRepository->update($data['id'],$data_update);

        return $update_receive_supply;

    }

    public function historyReceiveSupply(Request $request)
    {
        $records = $this->historyReceiveSupplyRepository->historyReceiveSupply($request['id']);
        return [
            "aaData" => $records,
        ];
    }

    public function rejectReceiveSupply(Request $request)
    {
        $data = $request->all();
        $status = 'false';
        if($data['reject_detail'] != null){
            $data_update = [
                'reject_status' => 1,
                'reject_detail' => $data['reject_detail'],
                'paper_status' => 3,
            ];
            $update_receive_material = $this->receiveSupplyRepository->update($data['id'],$data_update);
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
            $update = $this->receiveSupplyRepository->update($data['id'],$data_update);
        return $update;
    }

}
