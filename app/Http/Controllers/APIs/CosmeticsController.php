<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CosmeticsInterface;
use App\Models\Cosmetics;
use Illuminate\Support\Facades\Validator;

class CosmeticsController extends Controller
{
    private $cosmeticsRepository;
    public function __construct(CosmeticsInterface $cosmeticsRepository)
    {
        $this->cosmeticsRepository = $cosmeticsRepository;
    }

    public function select(Request $request)
    {
        $result = $this->cosmeticsRepository->all();
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
            // "company_id" => $postData['company_id']
        ];

        $totalRecordswithFilter = $totalRecords = $this->cosmeticsRepository->getAllCosmetics($param)->count();

        $records = $this->cosmeticsRepository->paginate($param);

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
            "abbreviation" => ["required"],

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_cosmetics = Cosmetics::create([
            "name" => $data['name'],
            "abbreviation" => $data['abbreviation'],
            "definition" => $data['definition'],
            "name_en" => $data['name_en'],
            "record_status" => 1
        ]);
        return $data;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_cosmetics = $this->cosmeticsRepository->update($request->id, $data);
        return $update_cosmetics;
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $view_edit = $this->cosmeticsRepository->find($data['id']);
        return $view_edit;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->cosmeticsRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }
}
