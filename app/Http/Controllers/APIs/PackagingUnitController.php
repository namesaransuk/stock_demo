<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Repositories\PackagingUnitInterface;
use Illuminate\Http\Request;
use App\Models\PackagingUnit;
use Illuminate\Support\Facades\Validator;

class PackagingUnitController extends Controller
{
    private $packagingUnitRepository;

    public function __construct(PackagingUnitInterface $packagingUnitRepository)
    {
        $this->packagingUnitRepository = $packagingUnitRepository;
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

        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage,
            // "company_id" => $postData['company_id']
        ];

        $totalRecordswithFilter = $totalRecords = $this->packagingUnitRepository->getAllPackagingUnit($param)->count();

        $records = $this->packagingUnitRepository->paginate($param);

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
            // "multiply" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $createPackaging = PackagingUnit::create([
            "name" => $data['name'],
            "name_en" => $data['name_en'],
            "abbreviation" => $data['abbreviation'],
            "definition" => $data['definition'],
            "record_status" => 1
        ]);
        return $createPackaging;
    }

    public function update(Request $request) 
    {

        $data = $request->all();
        $editproduct_type = $this->packagingUnitRepository->update($request->id, $data);
        return $editproduct_type;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->packagingUnitRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $dataproduct_type = $this->packagingUnitRepository->find($data['id']);
        return $dataproduct_type;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $updateproduct_type = $this->packagingUnitRepository->update($request->id, $data);
        return $updateproduct_type;
    }
}
