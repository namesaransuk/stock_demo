<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\HistoryProductCut;
use App\Models\HistoryRequsitionProduct;
use App\Models\ProductCut;
use App\Models\RequsitionProduct;
use App\Repositories\HistoryRequsitionProductInterface;
use App\Repositories\ProductCutInterface;
use App\Repositories\ProductInterface;
use App\Repositories\ProductLotInterface;
use App\Repositories\RequsitionProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequsitionProductController extends Controller
{
    private $productRepository;
    private $productLotRepository;
    private $requsitionProductRepository;
    private $productCutRepository;
    private $historyRequsitionProductRepository;

    public function __construct(ProductInterface $productRepository,RequsitionProductInterface $requsitionProductRepository,HistoryRequsitionProductInterface $historyRequsitionProductRepository,ProductLotInterface $productLotRepository,ProductCutInterface $productCutRepository)
    {
        $this->productRepository = $productRepository;
        $this->requsitionProductRepository = $requsitionProductRepository;
        $this->historyRequsitionProductRepository = $historyRequsitionProductRepository;
        $this->productLotRepository = $productLotRepository;
        $this->productCutRepository = $productCutRepository;
    }

    public function getProductLotAndProductsCut(Request $request)
    {
        $data = $request->all();
        foreach ($data as $product_id) {
            $product_id = $product_id['product_id'];
            $product_lots[] = $this->productLotRepository->getLotRemainById($product_id);
        }
        foreach ($product_lots as $product_lot) {
            foreach ($product_lot as $id) {
                $product_id = $id->id;
                $product_cut[] = $this->productCutRepository->getCutReturnById($product_id);
            }
        }
        return [
            "product_lots" => $product_lots,
            "product_cut" => $product_cut,
        ];
    }

    public function list(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $ins_cut = 0;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionProductRepository->count($param,$paper_status,$ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionProductRepository->getAllRequsitionProduct($param,$searchValue,$paper_status,$ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionProductRepository->paginate($param,$paper_status,$ins_cut);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function getProductLotByProductId(Request $request)
    {
        $data = $request->all();
        $product_lots = $this->productLotRepository->getLotRemainById($data['product_id']);
        $product_cut = $this->productCutRepository->all();
        return [
            "product_lots" => $product_lots,
            "product_cut" => $product_cut,
        ];
    }

    public function createRequsitionProduct(Request $request)
    {
        $data = $request->all();
        $full_addr = $data['house_no']." ".$data['tumbol']." ".$data['aumphur']." ".$data['province']." ".$data['postcode'];
        $user_id = $data['user_id'];
        if($data['recap'] == 'undefined'){
            $data['recap'] = "";
        }
            DB::beginTransaction();
            $create_requsition_product = null;
        try {
            $create_requsition_product = RequsitionProduct::create([
                "paper_no" => $data['paper_no'],
                "date" => $data['date'],
                "created_by" => $user_id,
                "updated_by" => $user_id,
                "stock_user_id" => $user_id,
                "recap" => $data['recap'],

                "receive_name" => $data['cus_name'],
                "receive_vehicle" => $data['vehicle'],
                "receive_house_no" => $data['house_no'],
                "receive_tumbol" => $data['tumbol'],
                "receive_aumphur" => $data['aumphur'],
                "receive_province" => $data['province'],
                "receive_postcode" => $data['postcode'],
                "receive_full_addr" => $full_addr,
                "receive_tel" => $data['tel'],
                "transport_type" => $data['transport_type'],
                'company_id' => $data['company_id'],
        ]);

            foreach ($data['product'] as $key => $value) {
                $create_product_cuts = ProductCut::create([
                    "action" => 1,
                    "qty" => $value['qty'],
                    "created_by" => $user_id,
                    "updated_by" => $user_id,
                    "product_lot_id" => $value['product_lot_id'],
                    "requsition_product_id" => $create_requsition_product->id,
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e){
            dd($e);
            DB::rollBack();
        }

        return $create_requsition_product;
    }

    public function editRequsitionProduct(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $user_id = $data['user_id'];
        $full_addr = $data['house_no']." ".$data['tumbol']." ".$data['aumphur']." ".$data['province']." ".$data['postcode'];
        $newedit_times = $data['edit_times'] + 1;
        if($data['recap_old'] == 'undefined'){
            $recap = '';
        }
        else{
            $recap = $data['recap_old'];
        }
        DB::beginTransaction();
        $create_requsition_product_history = null;
        try {
        $create_requsition_product_history = HistoryRequsitionProduct::create([
            "paper_no" => $data['paper_no'],
            "date" => $data['date'],
            "edit_times" => $data['edit_times'],
            "created_by" => $user_id,
            "updated_by" => $user_id,
            "stock_user_id" => $user_id,
            "recap" => $recap,

            "receive_name" => $data['cus_name'],
            "receive_vehicle" => $data['vehicle'],
            "receive_house_no" => $data['house_no'],
            "receive_tumbol" => $data['tumbol'],
            "receive_aumphur" => $data['aumphur'],
            "receive_province" => $data['province'],
            "receive_postcode" => $data['postcode'],
            "receive_full_addr" => $full_addr,
            "receive_tel" => $data['tel'],
            "transport_type" => $data['transport_type'],
            "requsition_product_id" => $data['id'],
            'company_id' => $data['company_id'],
        ]);

        foreach (json_decode($data['productOld']) as $key => $value) {
           $create_product_cut_history = HistoryProductCut::create([
            "datetime" => $value->datetime,
            "qty" => $value->qty,
            "created_by" => $value->created_by,
            "updated_by" => $value->updated_by,
            "product_lot_id" => $value->product_lot_id,
            "requsition_product_id" => $value->requsition_product_id,
            "history_requsition_product_id" => $create_requsition_product_history->id,
           ]);
        };

        $delete_product_cut_return = DB::table('product_cuts')->where('requsition_product_id', '=', $data['id'])->delete();
        if ($data['lengthproductOld'] > 0) {
            foreach (json_decode($data['productOld']) as $key => $value) {
               $create_product_cut_old = ProductCut::create([
                "action" => 1,
                "qty" => $value->qty,
                "created_by" => $data['created_by'],
                "updated_by" => $user_id,
                "product_lot_id" => $value->product_lot_id,
                "requsition_product_id" => $data['id'],
               ]);
            };
        }

        if ($data['lengthproduct']>0) {
            foreach ($data['product'] as $product) {
               $create_product_cut = ProductCut::create([
                "action" => 1,
                "qty" => $product['qty'],
                "created_by" => $data['created_by'],
                "updated_by" => $user_id,
                "product_lot_id" => $product['product_lot_id'],
                "requsition_product_id" => $data['id'],
               ]);
            };
        }

        $data_update = [
            'edit_times' => $newedit_times,
            'date' => $data['date'],
            'updated_by' => $data['user_id'],
            'recap' => $data['recap']
        ];

        $update_requsition_product = $this->requsitionProductRepository->update($data['id'],$data_update);
        DB::commit();
        }
        catch (\Exception $e){
            dd($e);
            DB::rollBack();
        }
        return $update_requsition_product;
    }

    public function getRequsitionProductLotByID(Request $request)
    {
        $data = $request->all();
        $product_cuts = $this->productCutRepository->getAllProductRequsitionLot($data['id']);
        // dd($product_cuts);
        return $product_cuts;
    }

    public function historyRequsitionProduct(Request $request)
    {
        $records = $this->historyRequsitionProductRepository->historyRequsitionProduct($request['id']);
        return [
            "aaData" => $records,
        ];
    }

    public function listInspect(Request $request)
    {
        $postData = $request->all();
        $paper_status = 1;
        $ins_cut = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionProductRepository->count($param,$paper_status,$ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionProductRepository->getAllRequsitionProduct($param,$searchValue,$paper_status,$ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionProductRepository->paginate($param,$paper_status,$ins_cut);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function listPending(Request $request)
    {
        $postData = $request->all();
        $paper_status = 2;
        $ins_cut = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionProductRepository->count($param,$paper_status,$ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionProductRepository->getAllRequsitionProduct($param,$searchValue,$paper_status,$ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionProductRepository->paginate($param,$paper_status,$ins_cut);

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
        $ins_cut = 1;
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
        $totalRecordswithFilter = $totalRecords = $this->requsitionProductRepository->count($param,$paper_status,$ins_cut);


        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->requsitionProductRepository->getAllRequsitionProduct($param,$searchValue,$paper_status,$ins_cut)->count();
        }


        // Fetch records
        $records = $this->requsitionProductRepository->paginate($param,$paper_status,$ins_cut);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function stepToInspect(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'ins_cut' => 1,
        ];
        $update_requsition_product = $this->requsitionProductRepository->update($data['id'],$data_update);
        return $update_requsition_product;
    }

    public function stepToPending(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 2,
            'audit_user_id' => $data['user_id'],
        ];
        $update_requsition_product = $this->requsitionProductRepository->update($data['id'],$data_update);
        return $update_requsition_product;
    }

    public function stepToHistory(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 3,
        ];
        $update_requsition_product = $this->requsitionProductRepository->update($data['id'],$data_update);
        return $update_requsition_product;
    }

    public function stepReject(Request $request)
    {
        $data = $request->all();
        $data_update = [
            'paper_status' => 1,
            'ins_cut' => 0,
        ];
        $update_requsition_product = $this->requsitionProductRepository->update($data['id'],$data_update);
        return $update_requsition_product;
    }

    public function delete(Request $request)
    {
        $data = $request->all();
            $data_update = [
                'paper_status' => 0,
            ];
            $update = $this->requsitionProductRepository->update($data['id'],$data_update);
        return $update;
    }
}
