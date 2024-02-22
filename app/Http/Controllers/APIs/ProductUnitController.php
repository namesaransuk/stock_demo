<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use App\Repositories\ProductUnitInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductUnitController extends Controller
{
    private $productUnitRepository;

    public function __construct(ProductUnitInterface $productUnitRepository )
    {
        $this->productUnitRepository = $productUnitRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->productUnitRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->productUnitRepository->getAllproductUnits($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->productUnitRepository->paginate($param);

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
            "multiply" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $createproduct_type = ProductUnit::create([
            "name" => $data['name'],
            "multiply" => $data['multiply'],
            "record_status" => 1
        ]);
        return $createproduct_type;
    }

    public function update(Request $request)
    {

            $data = $request->all();
            $editproduct_type = $this->productUnitRepository->update($request->id, $data);
            return $editproduct_type;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->productUnitRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $dataproduct_type = $this->productUnitRepository->find($data['id']);
        return $dataproduct_type;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $updateproduct_type = $this->productUnitRepository->update($request->id,$data);
        return $updateproduct_type;
    }
}
