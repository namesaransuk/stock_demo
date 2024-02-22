<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository )
    {
        $this->categoryRepository = $categoryRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->categoryRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->categoryRepository->getAllCategories($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->categoryRepository->paginate($param);

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
        $create_category = Category::create([
            "name" => $data['name'],
            "product_import_flag" => $data['product_import_flag'],
            "record_status" => 1
        ]);
        return $data;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->categoryRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();
        $data_category = $this->categoryRepository->find($data['id']);
        return $data_category;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_category = $this->categoryRepository->update($request->id,$data);
        return $update_category;
    }
}
