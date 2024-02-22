<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Repositories\SupplyInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplyController extends Controller
{
    private $supplyRepository;

    public function __construct(SupplyInterface $supplyRepository )
    {
        $this->supplyRepository = $supplyRepository;
    }

    public function suppliesList(Request $request)
    {
        $result = $this->supplyRepository->all();
        return $result;
    }

    public function list(Request $request)
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
        $totalRecordswithFilter = $totalRecords = $this->supplyRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->supplyRepository->getAllSupplies($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage,
            "company_id" => $postData['company_id']
        ];
        // Fetch records
        $records = $this->supplyRepository->paginate($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    protected function validateCheck(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "name" => ["required"],


        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_supply = Supply::create([
            "name" => $data['name'],
            "company_id" => $data['company_id'],
            "record_status" => 1
        ]);
        return $create_supply;
    }

    public function update(Request $request)
    {

            $data = $request->all();
            $edit_supply = $this->supplyRepository->update($request->id, $data);
            return $edit_supply;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->supplyRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_supply = $this->supplyRepository->find($data['id']);
        return $data_supply;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_supply = $this->supplyRepository->update($request->id,$data);
        return $update_supply;
    }

}
