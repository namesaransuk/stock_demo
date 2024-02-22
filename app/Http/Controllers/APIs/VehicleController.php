<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Repositories\VehicleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    private $vehicleRepository;
    public function __construct(VehicleInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->vehicleRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->vehicleRepository->getAllVehicles($searchValue)->count();
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
        $records = $this->vehicleRepository->paginate($param);

        return [
            "aaData" => $records,
            "draw" => $draw,
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
        ];
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $create_package = Vehicle::create([
            "brand" => $data['brand'],
            "model" => $data['model'],
            "plate" => $data['plate'],
            "company_id" => $data['company_id'],
            // "record_status" => 1,
        ]);
        return $create_package;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $status = 0;
        $this->vehicleRepository->update($request->id,$data);
        $status = 1;
        return ["status"=>$status];
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                // 'record_status' => 0
            ];
            $this->vehicleRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $view_edit = $this->vehicleRepository->find($data['id']);
        return $view_edit;
    }

    protected function validateCheck(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "brand" => ["required"],
            "model" => ['required'],
            "plate" => ['required'],


        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }
}
