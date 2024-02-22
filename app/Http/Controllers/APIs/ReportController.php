<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MaterialInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\ProductInterface;
use App\Repositories\SupplyInterface;

class ReportController extends Controller
{
    private $mat_impl;
    private $pack_impl;
    private $product_impl;
    private $supply_impl;

    public function __construct(MaterialInterface $mat_impl,PackagingInterface $pack_impl,ProductInterface $product_impl,SupplyInterface $supply_impl) {
        $this->mat_impl = $mat_impl;
        $this->pack_impl = $pack_impl;
        $this->product_impl = $product_impl;
        $this->supply_impl = $supply_impl;
    }

    public function reportReceiveMaterialList(Request $request)
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
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->mat_impl->countReceiveReport($param);

        // Fetch records
        $records = $this->mat_impl->paginateReceiveReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportReceivePackagingList(Request $request)
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
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->pack_impl->countReceiveReport($param);

        // Fetch records
        $records = $this->pack_impl->paginateReceiveReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportReceiveProductList(Request $request)
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
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->product_impl->countReceiveReport($param);

        // Fetch records
        $records = $this->product_impl->paginateReceiveReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportReceiveSupplyList(Request $request)
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
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->supply_impl->countReceiveReport($param);

        // Fetch records
        $records = $this->supply_impl->paginateReceiveReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportRequsitionMaterialList(Request $request)
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
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->mat_impl->countRequsitionReport($param);

        // Fetch records
        $records = $this->mat_impl->paginateRequsitionReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportRequsitionPackagingList(Request $request)
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
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->pack_impl->countRequsitionReport($param);

        // Fetch records
        $records = $this->pack_impl->paginateRequsitionReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportRequsitionProductList(Request $request)
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
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->product_impl->countRequsitionReport($param);

        // Fetch records
        $records = $this->product_impl->paginateRequsitionReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function reportRequsitionSupplyList(Request $request)
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
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "item_search" => $request->item_search,
            "company_id" => $request->company_id,
        ];
        // Total records
        $totalRecordswithFilter = $totalRecords = $this->supply_impl->countRequsitionReport($param);

        // Fetch records
        $records = $this->supply_impl->paginateRequsitionReport($param);
        // dd($records);
        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }
}
