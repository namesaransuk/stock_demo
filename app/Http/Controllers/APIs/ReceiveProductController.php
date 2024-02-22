<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\HistoryProductLot;
use App\Models\HistoryReceiveProduct;
use App\Models\ProductLot;
use App\Models\ReceiveProduct;
use App\Repositories\HistoryReceiveProductInterface;
use App\Repositories\ProductLotInterface;
use App\Repositories\ReceiveProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReceiveProductController extends Controller
{
    private $receiveProductRepository;
    private $historyReceiveProductRepository;
    private $productLotRepository;
    public function __construct(ReceiveProductInterface $receiveProductRepository, ProductLotInterface $productLotRepository,HistoryReceiveProductInterface $historyReceiveProductRepository)
    {
        $this->receiveProductRepository = $receiveProductRepository;
        $this->productLotRepository = $productLotRepository;
        $this->historyReceiveProductRepository = $historyReceiveProductRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->receiveProductRepository->count($param,$paper_status,$inspect_ready);

        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveProductRepository->getAllReceiveProducts($param,$searchValue,$paper_status,$inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveProductRepository->paginate($param,$paper_status,$inspect_ready);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function createReceiveProduct(Request $request)
    {
        DB::beginTransaction();
        $data = $request->all();
        $create_receive_product = null;
        try {

            $datetime = Carbon::createFromFormat("Y-m-d\TH:i", $data['date']);

            $now = $datetime->format('dmy');
            $paper = 'RPD' . $now;
            $chkCode = ReceiveProduct::where('paper_no', 'LIKE', $paper . '%')->orderBy('id', 'desc')->first();
            if (isset($chkCode)) {
                $running = intval(substr($chkCode->paper_no, 10)) + 1;
            } else {
                $chkCode = $paper . 0;
                $running = intval(substr($chkCode, 10)) + 1;
            }
            $padRunning = str_pad($running, 3, '0', STR_PAD_LEFT);

            $paper_no = $paper . '-' . $padRunning;

            $create_receive_product = ReceiveProduct::create([
                // 'paper_no' => $data['paper_no'],
                'paper_no' => $paper_no,
                'edit_times' => 0,
                'date' => $data['date'],
                'created_by' => $data['user_id'],
                'updated_by' => $data['user_id'],
                'stock_user_id' => $data['user_id'],
                'company_id' => $data['company_id'],
        ]);

            // dd($create_receive_product->id);
            foreach ($data['product'] as $product) {
                $create_product_lot = ProductLot::create([
                        'lot' => $product['lot'],
                        'qty' => $product['qty'],
                        'mfg' => $product['mfg'],
                        'exp' => $product['exp'],
                        'notation' => $product['notation'],
                        'company_id' => $product['company_id'],
                        'product_id' =>$product['name'],
                        'receive_product_id' => $create_receive_product->id,
                        'unit_id' => $product['unit_id'],
                ]);
            }
            // $result['test'] = 'success';
            DB::commit();
        } catch (\Exception $e){
            // dd($e);
            // $result['test'] = $e->getMessage();
            // $result['test2'] = $data['date'];
            DB::rollBack();
        }

        return $create_receive_product;
    }
    public function listProductLot(Request $request)
    {
        $postData = $request->all();
        $id = $postData['id'];
        ## Read value


            // Fetch records
            $records = $this->productLotRepository->getAllProductLot($id);

            return [
                "aaData" => $records,

            ];
    }

    public function editReceiveProduct(Request $request)
    {
        DB::beginTransaction();
        $update_receive_product = null;
        try {
            $data = $request->all();
            $recap_old = $data['recapold'];
            if ($data['recapold'] === null) {
                $recap_old = " ";
            }
            $newedit_times = $data['edit_times'] + 1;
            $create_history_receive_product = HistoryReceiveProduct::create([
                'paper_no' => $data['paper_no'],
                'edit_times' => $data['edit_times'],
                'date' => $data['date'],
                'created_by' => $data['created_by'],
                'updated_by' => $data['updated_by'],
                'production_user_id' => $data['production_user_id'],
                'stock_user_id' => $data['stock_user_id'],
                'receive_product_id' => $data['id'],
                'recap' => $recap_old,
                'company_id' => $data['company_id'],
            ]);

            foreach(json_decode($data['productOld']) as $productOld){
                $create_history_product_lit = HistoryProductLot::create([
                    'lot' => $productOld->lot,
                    'qty' => $productOld->qty,
                    'mfg' => $productOld->mfg,
                    'exp' => $productOld->exp,
                    'company_id' => $productOld->company_id,
                    'product_id' => $productOld->product_id,
                    'receive_product_id' => $productOld->receive_product_id,
                    'unit_id' => $productOld->unit_id,
                    'history_receive_product_id' => $create_history_receive_product->id,
                ]);
            }
            $delete_product_lot = DB::table('product_lots')->where('receive_product_id', '=', $data['id'])->delete();
            if ($data['lengthproductOld'] > 0) {
                foreach ($data['productold'] as $productold) {
                    $create_product_lot_old = ProductLot::create([
                        'lot' => $productold['lot'],
                        'qty' => $productold['qty'],
                        'mfg' => $productold['mfg'],
                        'exp' => $productold['exp'],
                        'notation' => $productold['notation'],
                        'company_id' => $productold['company_id'],
                        'product_id' => $productold['product_id'],
                        'receive_product_id' => $data['id'],
                        'unit_id' => $productold['unit_id'],
                    ]);
                }
            }

            if ($data['lengthproduct'] > 0) {
                foreach ($data['product'] as $product) {
                    $create_product_lot = ProductLot::create([
                        'lot' => $product['lot'],
                        'qty' => $product['qty'],
                        'mfg' => $product['mfg'],
                        'exp' => $product['exp'],
                        'notation' => $product['notation'],
                        'company_id' => $product['company_id'],
                        'product_id' => $product['product_id'],
                        'receive_product_id' => $data['id'],
                        'unit_id' => $product['unit_id'],
                    ]);
                }
            }

            $data_update = [
                'edit_times' => $newedit_times,
                'date' => $data['date'],
                'updated_by' => $data['user_id'],
                'recap' => $data['recap'],
            ];
            $update_receive_product = $this->receiveProductRepository->update($data['id'],$data_update);
            DB::commit();
        } catch (\Exception $e){
            dd($e);
            DB::rollBack();
        }
        return $update_receive_product;

    }

    public function historyReceiveProducts(Request $request)
    {
        $records = $this->historyReceiveProductRepository->historyReceiveProduct($request['id']);
        return [
            "aaData" => $records,

        ];
    }

    public function getTemplateDetail(Request $request)
    {
        $template_detail = $this->receiveProductRepository->getTemplateDetailByTemplateID($request['id']);
        return $template_detail;
    }

    public function listPendingReceiveProduct(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->receiveProductRepository->countPending();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveProductRepository->getAllPendingReceiveProducts($searchValue)->count();
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
        $records = $this->receiveProductRepository->paginatePendingListReceiveProducts($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listMasterReceiveProduct(Request $request)
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
            "company_id" => $request->company_id,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->receiveProductRepository->count($param,$paper_status,$inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveProductRepository->getAllReceiveProducts($param,$searchValue,$paper_status,$inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveProductRepository->paginate($param,$paper_status,$inspect_ready);

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
        $update_receive_product = $this->receiveProductRepository->update($data['id'],$data_update);
        // dd($data);
        return $update_receive_product;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 3,
        ];
        $update_receive_product = $this->receiveProductRepository->update($data['id'],$data_update);
        // dd($data);
        return $update_receive_product;
    }

    public function stepBackToReceive(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'inspect_ready' => 0,
        ];
        $update_receive_product = $this->receiveProductRepository->update($data['id'],$data_update);
        // dd($data);
        return $update_receive_product;
    }

    public function listCheckReceiveProduct(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->receiveProductRepository->count($param,$paper_status,$inspect_ready);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->receiveProductRepository->getAllReceiveProducts($param,$searchValue,$paper_status,$inspect_ready)->count();
        }

        // Fetch records
        $records = $this->receiveProductRepository->paginate($param,$paper_status,$inspect_ready);

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
        $update_receive_product = $this->receiveProductRepository->update($data['id'],$data_update);
        return $update_receive_product;
    }

    public function stepBackToInspect(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'inspect_ready' => 1,
        ];
        $update_receive_product = $this->receiveProductRepository->update($data['id'],$data_update);
        // dd($data);
        return $update_receive_product;
    }

    public function delete(Request $request)
    {
        $data = $request->all();
            $data_update = [
                'paper_status' => 0,
            ];
            $update = $this->receiveProductRepository->update($data['id'],$data_update);
        return $update;
    }
}
