<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CategoryInterface;
use App\Repositories\FdaBrandInterface;
use App\Repositories\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productRepository;
    private $categoryRepository;
    private $fdaBrandRepository;

    public function __construct(CategoryInterface $categoryRepository, ProductInterface $productRepository, FdaBrandInterface $fdaBrandRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->fdaBrandRepository = $fdaBrandRepository;
    }

    public function productsList(Request $request)
    {
        $result = $this->productRepository->all();
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
        $totalRecordswithFilter = $totalRecords = $this->productRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->productRepository->getAllProducts($searchValue, $postData['company_id'])->count();
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
        $records = $this->productRepository->paginate($param);

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

        $brand = $this->fdaBrandRepository->find($data['brand_id']);
        $preCode = "FG" . $brand->abbreviation;

        $chkCode = Product::where('itemcode', 'LIKE', $preCode . '%')->orderBy('id', 'desc')->first();
        if (isset($chkCode)) {
            $running = intval(substr($chkCode->itemcode, 5)) + 1;
        } else {
            $chkCode = $preCode . 0;
            $running = intval(substr($chkCode, 5)) + 1;
        }
        $padRunning = str_pad($running, 5, '0', STR_PAD_LEFT);

        $product_code = $preCode . $padRunning;

        $create_product = Product::create([
            "name" => $data['name'],
            "brand_id" => $data['brand_id'],
            "itemcode" => $product_code,
            "record_status" => 1,
            "company_id" => $data['company_id'],
            "category_id" => $data['category_id']
        ]);
        return $create_product;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_product = $this->productRepository->update($request->id, $data);
        return $update_product;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->productRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $view_edit = $this->productRepository->find($data['id']);
        return $view_edit;
    }
}
