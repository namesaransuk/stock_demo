<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Repositories\MaterialCutReturnInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\PackagingCutReturnInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingLotInterface;
use App\Repositories\ProductCutInterface;
use App\Repositories\ProductInterface;
use App\Repositories\ProductLotInterface;
use App\Repositories\SupplyCutInterface;
use App\Repositories\SupplyInterface;
use App\Repositories\SupplyLotInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(
        MaterialInterface $mat_impl,
        PackagingInterface $pack_impl,
        ProductInterface $product_impl,
        SupplyInterface $supply_impl,

        MaterialLotInterface $mat_lot_impl,
        PackagingLotInterface $pack_lot_impl,
        ProductLotInterface $product_lot_impl,
        SupplyLotInterface $supply_lot_impl,

        MaterialCutReturnInterface $mat_cutreturn_impl,
        PackagingCutReturnInterface $pack_cutreturn_impl,
        ProductCutInterface $product_cutreturn_impl,
        SupplyCutInterface $supply_cutreturn_impl
        ) {
            $this->mat_impl = $mat_impl;
            $this->pack_impl = $pack_impl;
            $this->product_impl = $product_impl;
            $this->supply_impl = $supply_impl;

            $this->mat_lot_impl = $mat_lot_impl;
            $this->pack_lot_impl = $pack_lot_impl;
            $this->product_lot_impl = $product_lot_impl;
            $this->supply_lot_impl = $supply_lot_impl;

            $this->mat_cutreturn_impl = $mat_cutreturn_impl;
            $this->pack_cutreturn_impl = $pack_cutreturn_impl;
            $this->product_cutreturn_impl = $product_cutreturn_impl;
            $this->supply_cutreturn_impl = $supply_cutreturn_impl;
        }

    public function materialList(Request $request)
    {
        $postData = $request->all();
        $id = $request->id;
        // dd($request->id);
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
            "rowperpage" => $rowperpage,
            "mat_search" => $request->mat_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->mat_impl->countInventory($param);

        // Fetch records
        $records = $this->mat_impl->paginateInventory($param);

        //get current remain on row
        $receive_lots = $this->mat_lot_impl->getData($param);
        $cut_returns = $this->mat_cutreturn_impl->getData($param);
        $sum = 0;
        foreach($records as $key => $row_data){
            $date = new Carbon($row_data->created_at);
            $lot = $row_data->lot;
            $lotCount = 0;
            $cutCount = 0;
            $returnCount = 0;
            foreach($receive_lots as $key2=>$row_data2){
                $row_date2 = new Carbon($row_data2->created_at);
                if($row_date2 <= $date && $row_data2->action == 4){
                    $lotCount += $row_data2->weight_total;
                }
                // echo "date : ".$date," Row Date : ",$row_date;
            }

            foreach($cut_returns as $key3 => $row_data3){
                $row_date3 = new Carbon($row_data3->created_at);
                if($row_date3 <= $date){
                    if($row_data3->action == 1){
                        $cutCount += $row_data3->weight;
                    }
                    if($row_data3->action == 2){
                        $returnCount += $row_data3->weight;
                    }
                }
            }

            $sum = ($lotCount - $cutCount) + $returnCount;
            $row_data->lotCount = $lotCount;
            $row_data->cutCount = $cutCount;
            $row_data->returnCount = $returnCount;
            $row_data->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
        }
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function packagingList(Request $request)
    {
        $postData = $request->all();
        $id = $request->id;
        // dd($request->id);
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
            "rowperpage" => $rowperpage,
            "mat_search" => $request->mat_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->pack_impl->countInventory($param);

        // Fetch records
        $records = $this->pack_impl->paginateInventory($param);

        //get current remain on row
        $receive_lots = $this->pack_lot_impl->getData($param);
        $cut_returns = $this->pack_cutreturn_impl->getData($param);
        $sum = 0;
        foreach($records as $key => $row_data){
            $date = new Carbon($row_data->created_at);
            $lotCount = 0;
            $cutCount = 0;
            $returnCount = 0;
            $claimCount = 0;
            foreach($receive_lots as $key2=>$row_data2){
                $row_date2 = new Carbon($row_data2->created_at);
                if($row_date2 <= $date && $row_data2->action == 4){
                    $lotCount += $row_data2->qty;
                }
                // echo "date : ".$date," Row Date : ",$row_date;
            }

            foreach($cut_returns as $key3 => $row_data3){
                $row_date3 = new Carbon($row_data3->created_at);
                if($row_date3 <= $date){
                    if($row_data3->action == 1){
                        $cutCount += $row_data3->qty;
                    }
                    if($row_data3->action == 2){
                        $returnCount += $row_data3->qty;
                    }
                    if($row_data3->action == 4){
                        $claimCount += $row_data3->qty;
                    }
                }
            }

            $sum = ($lotCount - $cutCount) + $returnCount + $claimCount;
            $row_data->lotCount = $lotCount;
            $row_data->cutCount = $cutCount;
            $row_data->returnCount = $returnCount;
            $row_data->claimCount = $claimCount;
            $row_data->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
        }
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }
    //
    public function productList(Request $request)
    {
        $postData = $request->all();
        $id = $request->id;
        // dd($request->id);
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
            "rowperpage" => $rowperpage,
            "mat_search" => $request->mat_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->product_impl->countInventory($param);

        // Fetch records
        $records = $this->product_impl->paginateInventory($param);

        //get current remain on row
        $receive_lots = $this->product_lot_impl->getData($param);
        $cut_returns = $this->product_cutreturn_impl->getData($param);
        $sum = 0;
        foreach($records as $key => $row_data){
            $date = new Carbon($row_data->created_at);
            $lotCount = 0;
            $cutCount = 0;
            foreach($receive_lots as $key2=>$row_data2){
                $row_date2 = new Carbon($row_data2->created_at);
                if($row_date2 <= $date){
                    $lotCount += $row_data2->qty;
                }
                // echo "date : ".$date," Row Date : ",$row_date;
            }

            foreach($cut_returns as $key3 => $row_data3){
                $row_date3 = new Carbon($row_data3->created_at);
                if($row_date3 <= $date){
                    if($row_data3->action == 1){
                        $cutCount += $row_data3->qty;
                    }

                }
            }

            $sum = ($lotCount - $cutCount);
            $row_data->lotCount = $lotCount;
            $row_data->cutCount = $cutCount;
            $row_data->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
        }
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }
    public function supplyList(Request $request)
    {
        $postData = $request->all();
        $id = $request->id;
        // dd($request->id);
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
            "rowperpage" => $rowperpage,
            "mat_search" => $request->mat_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->supply_impl->countInventory($param);

        // Fetch records
        $records = $this->supply_impl->paginateInventory($param);
        //get current remain on row
        $receive_lots = $this->supply_lot_impl->getData($param);
        $cut_returns = $this->supply_cutreturn_impl->getData($param);
        $sum = 0;
        foreach($records as $key => $row_data){
            $date = new Carbon($row_data->created_at);
            $lotCount = 0;
            $cutCount = 0;
            foreach($receive_lots as $key2=>$row_data2){
                $row_date2 = new Carbon($row_data2->created_at);
                if($row_date2 <= $date && $row_data2->action == 2){
                    $lotCount += $row_data2->qty;
                }
                // echo "date : ".$date," Row Date : ",$row_date;
            }

            foreach($cut_returns as $key3 => $row_data3){
                $row_date3 = new Carbon($row_data3->created_at);
                if($row_date3 <= $date){
                    if($row_data3->action == 1){
                        $cutCount += $row_data3->qty;
                    }

                }
            }

            $sum = ($lotCount - $cutCount);
            $row_data->lotCount = $lotCount;
            $row_data->cutCount = $cutCount;
            $row_data->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
            // $records[$key]->currentRemain = $sum;
        }
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }
}
