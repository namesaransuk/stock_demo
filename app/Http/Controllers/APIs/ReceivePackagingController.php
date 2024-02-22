<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\HistoryPackagingLot;
use App\Models\HistoryReceivePackaging;
use App\Models\PackagingLot;
use App\Models\ReceivePackaging;
use App\Models\TransportPic;
use App\Repositories\HistoryReceivePackagingInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingLotInterface;
use App\Repositories\ReceivePackagingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ReceivePackagingController extends Controller
{
    private $receivePackagingRepository;
    private $packagingRepository;
    private $conmpanyRepository;
    private $packagingLotRepository;
    private $historyReceivePackagingRepository;
    public function __construct(ReceivePackagingInterface $receivePackagingRepository, PackagingInterface $packagingRepository, PackagingLotInterface $packagingLotRepository, HistoryReceivePackagingInterface $historyReceivePackagingRepository)
    {
        $this->receivePackagingRepository = $receivePackagingRepository;
        $this->packagingRepository = $packagingRepository;
        $this->packagingLotRepository = $packagingLotRepository;
        $this->historyReceivePackagingRepository = $historyReceivePackagingRepository;
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
            "company_id" => $request->company_id,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Total records
        // dd($totalRecordswithFilter);
        $totalRecordswithFilter = $totalRecords = $this->receivePackagingRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receivePackagingRepository->getAllReceivePackagings($param, $searchValue, $paper_status, $inspect_ready)->count();
        }


        // Fetch records
        $records = $this->receivePackagingRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listMasterReceivePackaging(Request $request)
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
            "company_id" => $request->company_id,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receivePackagingRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receivePackagingRepository->getAllReceivePackagings($param, $searchValue, $paper_status, $inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receivePackagingRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }


    public function createReceivePackaging(Request $request)
    {
        DB::beginTransaction();
        $create_receive_packaging = null;
        try {
            $data = $request->all();
            if ($data['po_file']) {
                $po_name = save_image($data['po_file'], 500, '/po_packaging/');
            };

            $datetime = Carbon::createFromFormat("Y-m-d", $data['date']);

            $now = $datetime->format('dmy');
            $paper = 'RPK' . $now;
            $chkCode = ReceivePackaging::where('paper_no', 'LIKE', $paper . '%')->orderBy('id', 'desc')->first();
            if (isset($chkCode)) {
                $running = intval(substr($chkCode->paper_no, 10)) + 1;
            } else {
                $chkCode = $paper . 0;
                $running = intval(substr($chkCode, 10)) + 1;
            }
            $padRunning = str_pad($running, 3, '0', STR_PAD_LEFT);

            $paper_no = $paper . '-' . $padRunning;

            $create_receive_packaging =  ReceivePackaging::create([
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
                'company_id' => $data['company_id'],
                'po_no' => $data['po_no'],
                'po_file_name' => $po_name,
            ]);

            foreach ($data['packaging'] as $packaging) {
                $coa = "0";
                if (isset($packaging['coa'])) {
                    $coa = save_image($packaging['coa'], 500, '/coa_packaging/');
                };

                $create_packaging_lot = PackagingLot::create([
                    "lot_no_pm" => null,
                    "lot" => $packaging['lot'],
                    "coa" => $coa,
                    "qty" => $packaging['qty'],
                    "mfg" => $packaging['mfg'],
                    "exp" => $packaging['exp'],
                    "action" => "1",
                    "company_id" => $packaging['company_id'],
                    "packaging_id" => $packaging['packaging_id'],
                    "receive_packaging_id" => $create_receive_packaging->id,

                ]);
            }
            $result['test'] = 'success';
            DB::commit();
        } catch (\Exception $e) {
            $result['test'] = $e->getMessage();
            $result['test2'] = $datetime;
            // $result['test3'] = $create_packaging_lot;
            DB::rollBack();
        }

        return $result;
    }


    public function listViewEditReceivePackaging(Request $request)
    {
        $postData = $request->all();
        $receivepackaging = $this->receivePackagingRepository->find($postData['id']);
        return $receivepackaging;
    }

    public function listPackagingLot(Request $request)
    {
        $postData = $request->all();
        $id = $postData['id'];
        ## Read value


        // Fetch records
        $records = $this->packagingLotRepository->getAllPackagingLot($id);

        return [
            "aaData" => $records,

        ];
    }

    public function editReceivePackaging(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $newedit_times = $data['edit_times'] + 1;
        $recap_old = $data['recapold'];
        if ($data['recapold'] === null) {
            $recap_old = " ";
        }
        DB::beginTransaction();
        $create_receive_packaging = null;
        try {
            $create_receive_packaging_history = HistoryReceivePackaging::create([
                'paper_no' => $data['paper_no'],
                'po_no' => $data['po_no'],
                'po_file_name' => $data['po_file'],
                'edit_times' => $data['edit_times'],
                'date' => $data['date'],
                'history_flag' => $data['history_flag'],
                'created_by' => $data['created_by'],
                'updated_by' => $data['updated_by'],
                'receive_packaging_id' => $data['id'],
                'stock_user_id' => $data['stock_user_id'],
                'admin_user_id' => $data['admin_user_id'],
                'brand_vendor_id' => $data['brand_vendor_id'],
                'logistic_vendor_id' => $data['logistic_vendor_id'],
                'recap' => $recap_old,
                'company_id' => $data['company_id'],
            ]);

            // dd($data);
            // dd($data['packagingOld']);
            foreach (json_decode($data['packagingOld']) as $datapackagingOld) {
                $create_history_packaging_lot = HistoryPackagingLot::create([
                    "lot_no_pm" => $datapackagingOld->lot_no_pm,
                    "lot" => $datapackagingOld->lot,
                    "coa" => $datapackagingOld->coa,
                    "qty" => $datapackagingOld->qty,
                    "mfg" => $datapackagingOld->mfg,
                    "exp" => $datapackagingOld->exp,
                    "action" => $datapackagingOld->action,
                    "quality_check" => $datapackagingOld->quality_check,
                    "transport_check" => $datapackagingOld->transport_check,
                    "notation" => $datapackagingOld->notation,
                    "company_id" => $datapackagingOld->company_id,
                    "packaging_id" => $datapackagingOld->packaging_id,
                    "receive_packaging_id" => $datapackagingOld->receive_packaging_id,
                    "history_receive_packaging_id" => $create_receive_packaging_history->id
                ]);
            }
            $delete_packaging_lot =  DB::table('packaging_lots')->where('receive_packaging_id', '=', $data['id'])->delete();

            if ($data['lengthpackaging'] > 0) {
                foreach ($data['packaging'] as $packaging) {
                    $coa = "0";
                    if (isset($packaging['coa'])) {
                        $coa = save_image($packaging['coa'], 500, '/coa_packaging/');
                    };
                    $create_packaging_lot = PackagingLot::create([
                        "lot" => $packaging['lot'],
                        "coa" => $coa,
                        "qty" => $packaging['qty'],
                        "mfg" => $packaging['mfg'],
                        "exp" => $packaging['exp'],
                        "company_id" => $packaging['company_id'],
                        "packaging_id" => $packaging['packaging_id'],
                        "receive_packaging_id" => $data['id'],
                    ]);
                }
            }
            if ($data['lengthpackagingOld'] > 0) {
                foreach ($data['packagingold'] as $packagingold) {
                    $create_packaging_lot_old = PackagingLot::create([
                        "lot" => $packagingold['lot'],
                        "qty" => $packagingold['qty'],
                        "mfg" => $packagingold['mfg'],
                        "coa" => $packagingold['coa'],
                        "exp" => $packagingold['exp'],
                        "company_id" => $packagingold['company_id'],
                        "packaging_id" => $packagingold['packaging_id'],
                        "receive_packaging_id" => $data['id']
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'date' => $data['date'],
            'updated_by' => $data['user_id'],
            'recap' => $data['recap'],
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);

        return  $update_receive_packaging;
    }
    public function historyReceivePackagings(Request $request)
    {
        $records = $this->historyReceivePackagingRepository->historyReceivePackaging($request['id']);
        return [
            "aaData" => $records,

        ];
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
                    'packaging_lot_id' => $id,
                ]);
            }
        };
        $update_transport_check = $this->packagingLotRepository->update($request->id, $data);
        return $update_transport_check;
    }

    public function getTemplateDetail(Request $request)
    {
        $template_detail = $this->receivePackagingRepository->getTemplateDetailByTemplateID($request['id']);
        return $template_detail;
    }

    public function editInspect_ready(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'inspect_ready' => 1,
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);
        return $update_receive_packaging;
    }

    public function stepBackToReceive(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'inspect_ready' => 0,
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_packaging;
    }

    public function stepToLotNoPM(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 2,
        ];
        $update_receive_packaging2 = $this->receivePackagingRepository->update($data['id'], $data_update);
        return $update_receive_packaging2;
    }

    public function stepBackToInspect(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'inspect_ready' => 1,
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_packaging;
    }

    public function stepToPending(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 3,
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_packaging;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 4,
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);
        // dd($data);
        return $update_receive_packaging;
    }

    public function listInspectReceivePackaging(Request $request)
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
        // dd($totalRecordswithFilter);
        $totalRecordswithFilter = $totalRecords = $this->receivePackagingRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receivePackagingRepository->getAllReceivePackagings($param, $searchValue, $paper_status, $inspect_ready)->count();
        }


        // Fetch records
        $records = $this->receivePackagingRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listReceivePackagingLotNoPm(Request $request)
    {
        $postData = $request->all();
        $paper_status = 2;
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
        // dd($totalRecordswithFilter);
        $totalRecordswithFilter = $totalRecords = $this->receivePackagingRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receivePackagingRepository->getAllReceivePackagings($param, $searchValue, $paper_status, $inspect_ready)->count();
        }


        // Fetch records
        $records = $this->receivePackagingRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listReceivePackagingMaster(Request $request)
    {
        $postData = $request->all();
        $paper_status = 3;
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
        // dd($totalRecordswithFilter);
        $totalRecordswithFilter = $totalRecords = $this->receivePackagingRepository->count($param, $paper_status, $inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receivePackagingRepository->getAllReceivePackagings($param, $searchValue, $paper_status, $inspect_ready)->count();
        }


        // Fetch records
        $records = $this->receivePackagingRepository->paginate($param, $paper_status, $inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPendingReceivePackaging(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->receivePackagingRepository->countPending();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receivePackagingRepository->getAllPendingReceivePackagings($searchValue)->count();
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
        $records = $this->receivePackagingRepository->paginatePendingListReceivePackagings($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function rejectReceivePackaging(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'reject_status' => 1,
            'paper_status' => 3,
        ];
        $update_receive_packaging = $this->receivePackagingRepository->update($data['id'], $data_update);
        return $update_receive_packaging;
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 0,
        ];
        $update = $this->receivePackagingRepository->update($data['id'], $data_update);
        return $update;
    }
}
