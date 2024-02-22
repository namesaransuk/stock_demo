<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    private $vendorRepository;
    public function __construct(VendorInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function suppliersList() {
        $suppliers = $this->vendorRepository->all();
        return $suppliers;
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
        $totalRecordswithFilter = $totalRecords = $this->vendorRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->vendorRepository->getAllvendors($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->vendorRepository->paginate($param);

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

        $create_package = Vendor::create([
            "brand" => $data['brand'],
            "abbreviation" => $data['abbreviation'],
            "address" => $data['address'],
            "contact_name" => $data['contact_name'],
            "contact_number" => $data['contact_number'],
            "type" => $data['type'],
            "record_status" => 1,
        ]);
        return $create_package;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $status = 0;
        $this->vendorRepository->update($request->id,$data);
        $status = 1;
        return ["status"=>$status];
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->vendorRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $view_edit = $this->vendorRepository->find($data['id']);
        return $view_edit;
    }

    protected function validateCheck(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "brand" => ["required"],
            "abbreviation" => ["required"],
            "address" => ['required'],
            "contact_name" => ['required'],
            "contact_number" => ['required'],
            "type" => ['required'],


        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }
}
