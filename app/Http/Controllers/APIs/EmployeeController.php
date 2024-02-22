<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Repositories\EmployeeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    private $employeeRepository;

    public function __construct(EmployeeInterface $employeeRepository )
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function list(Request $request)
    {
        $postData = $request->all();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column email
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->employeeRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->employeeRepository->getAllEmployees($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->employeeRepository->paginate($param);

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
            "emp_no" => ["required"],
            "fname" => ["required"],
            "lname" => ["required"],
            "tel" => ["required"],
            "citizen_no" => ["required"],
            "prefix_id" => ["required"],
            "company_id" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_employee = Employee::create([
            "emp_no" => $data['emp_no'],
            "fname" => $data['fname'],
            "lname" => $data['lname'],
            "tel" => $data['tel'],
            "citizen_no" => $data['citizen_no'],
            "prefix_id" => $data['prefix_id'],
            "company_id" => $data['company_id'],
        ]);
        return $create_employee;
    }

    public function update(Request $request)
    {
            $data = $request->all();
            $edit_employee = $this->employeeRepository->update($request->id, $data);
            return $edit_employee;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->employeeRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();
        $data_employee = $this->employeeRepository->find($data['id']);
        return $data_employee;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_employee = $this->employeeRepository->update($request->id,$data);
        return $update_employee;
    }
}
