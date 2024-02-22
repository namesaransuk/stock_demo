<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Repositories\CategoryInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\VendorInterface;
use App\Repositories\CosmeticsInterface;
use App\Repositories\SupplementInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    private $materialRepository;
    private $categoryRepository;
    private $vendorRepository;
    private $cosmeticsRepository;
    private $supplementRepository;

    public function __construct(
        CategoryInterface $categoryRepository,
        MaterialInterface $materialRepository,
        VendorInterface $vendorRepository,
        CosmeticsInterface $cosmeticsRepository,
        SupplementInterface $supplementRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->materialRepository = $materialRepository;
        $this->vendorRepository = $vendorRepository;
        $this->cosmeticsRepository = $cosmeticsRepository;
        $this->supplementRepository = $supplementRepository;
    }

    public function materialsList(Request $request)
    {
        $result = $this->materialRepository->getAllMaterial();
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

        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage,
            "company_id" => $postData['company_id'],
            "categoryFilter" => $postData['categoryFilter'],
        ];

        // Total records
        //        $totalRecordswithFilter = $totalRecords = $this->materialRepository->count();
        //        if (strlen($searchValue) > 0) {
        $totalRecordswithFilter =  $totalRecords = $this->materialRepository->getAllMaterials($param)->count();
        //        }
        // Fetch records
        $records = $this->materialRepository->paginate($param);

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
            // "trade_name" => ["required"],

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $supplier = $this->vendorRepository->find($data['supplier_id']);
        $supplier_code =  $supplier->abbreviation;

        if ($data['category_id'] == 1) {
            $sub_category_code = $this->cosmeticsRepository->find($data['sub_category_id']);
        } else if ($data['category_id'] == 2) {
            $sub_category_code = $this->supplementRepository->find($data['sub_category_id']);
        }

        $preCode = "RM" . ($data['company_id'] == 1 ? "C" : ($data['company_id'] == 2 ? "G" : ($data['company_id'] == 3 ? "I" : "0"))) . $sub_category_code->abbreviation;

        $chkCode = Material::where('itemcode', 'LIKE', $preCode . '%' . $supplier_code)->orderBy('id', 'desc')->first();
        if (isset($chkCode)) {
            $running = intval(substr($chkCode->itemcode, 5)) + 1;
        } else {
            $chkCode = $preCode . 0;
            $running = intval(substr($chkCode, 5)) + 1;
        }
        $padRunning = str_pad($running, 4, '0', STR_PAD_LEFT);

        $material_code = $preCode . $padRunning . $supplier_code;

        $create_material = Material::create([
            "name" => $data['name'],
            "itemcode" => $material_code,
            // "trade_name" => null,
            "is_active" => $data['is_active'],
            "record_status" => 1,
            "company_id" => $data['company_id'],
            "supplier_id" => $data['supplier_id'],
            "category_id" => $data['category_id'],
            "sub_category_id" => $data['sub_category_id']
        ]);
        return $create_material;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        // foreach ($data as $item) {
        // $supplier_explode = explode('|', $data['supplier_id']);
        // $supplier_id = $supplier_explode[0];
        // $data['supplier_id'] = $supplier_id;
        // $supplier_code = $supplier_explode[1];
        // }
        $update_material = $this->materialRepository->update($request->id, $data);
        return $update_material;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->materialRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $view_edit = $this->materialRepository->find($data['id']);
        return $view_edit;
    }
}
