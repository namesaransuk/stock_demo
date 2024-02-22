<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Packaging;
use App\Repositories\FdaBrandInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingUnitInterface;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PackagingController extends Controller
{
    private $fdaBrandRepository;
    private $packageRepository;
    private $packageUnitRepository;
    private $vendorRepository;
    public function __construct(
        FdaBrandInterface $fdaBrandRepository, 
        PackagingInterface $packageRepository, 
        PackagingUnitInterface $packageUnitRepository, 
        VendorInterface $vendorRepository)
    {
        $this->fdaBrandRepository = $fdaBrandRepository;
        $this->packageRepository = $packageRepository;
        $this->packageUnitRepository = $packageUnitRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function packagingsList(Request $request)
    {
        $result = $this->packageRepository->all();
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
        $totalRecordswithFilter = $totalRecords = $this->packageRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->packageRepository->getAllPackages($searchValue)->count();
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
        $records = $this->packageRepository->paginate($param);

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

        $brand = $this->fdaBrandRepository->find($data['brand_id']);
        $type_code = $this->packageUnitRepository->find($data['packaging_type_id']);
        $preCode = "PK" . $brand->abbreviation . $type_code->abbreviation;

        $chkCode = Packaging::where('itemcode', 'LIKE', $preCode . '%')->orderBy('id', 'desc')->first();
        if (isset($chkCode)) {
            $running = intval(substr($chkCode->itemcode, 7)) + 1;
        } else {
            $chkCode = $preCode . 0;
            $running = intval(substr($chkCode, 7)) + 1;
        }
        $padRunning = str_pad($running, 4, '0', STR_PAD_LEFT);

        $packaging_code = $preCode . $padRunning;

        $create_package = Packaging::create([
            "name" => $data['name'],
            "packaging_type_id" => $data['packaging_type_id'],
            "itemcode" => $packaging_code,
            "weight_per_qty" => $data['weight_per_qty'],
            "volumetric_unit" => $data['volumetric_unit'],
            "is_active" => 1,
            "record_status" => 1,
            "brand_id" => $data['brand_id'],
            "company_id" => $data['company_id'],
        ]);
        return $create_package;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $status = 0;
        $this->packageRepository->update($request->id, $data);
        $status = 1;
        return ["status" => $status];
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->packageRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $view_edit = $this->packageRepository->find($data['id']);
        return $view_edit;
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
}
