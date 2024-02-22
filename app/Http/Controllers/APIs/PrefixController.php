<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Prefix;
use App\Repositories\PrefixInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrefixController extends Controller
{
    private $prefixRepository;

    public function __construct(PrefixInterface $prefixRepository )
    {
        $this->prefixRepository = $prefixRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->prefixRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->prefixRepository->getAllPrefixes($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->prefixRepository->paginate($param);

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
        $create_prefix = Prefix::create([
            "name" => $data['name'],
            "record_status" => 1
        ]);
        return $create_prefix;
    }

    public function update(Request $request)
    {

            $data = $request->all();
            $edit_prefix = $this->prefixRepository->update($request->id, $data);
            return $edit_prefix;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->prefixRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_prefix = $this->prefixRepository->find($data['id']);
        return $data_prefix;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_prefix = $this->prefixRepository->update($request->id,$data);
        return $update_prefix;
    }
}
