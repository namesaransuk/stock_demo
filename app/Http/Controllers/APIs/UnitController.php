<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Repositories\UnitInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    private $unitRepository;

    public function __construct(UnitInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function unitsList(Request $request)
    {
        $units = $this->unitRepository->all();
        return $units;
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
        $totalRecordswithFilter = $totalRecords = $this->unitRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->unitRepository->getAllUnits($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->unitRepository->paginate($param);

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
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_unit = Unit::create([
            "name" => $data['name'],
            "name_en" => $data['name_en'],
            "abbreviation" => $data['abbreviation'],
            "definition" => $data['definition'],
            "record_status" => 1
        ]);
        return $create_unit;
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $edit_unit = $this->unitRepository->update($request->id, $data);
        return $edit_unit;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->unitRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_unit = $this->unitRepository->find($data['id']);
        return $data_unit;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_unit = $this->unitRepository->update($request->id, $data);
        return $update_unit;
    }
}
