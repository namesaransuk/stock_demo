<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\InspectTopic;
use App\Repositories\InspectTopicInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InspectTopicController extends Controller
{
    private $inspectTopicRepository;

    public function __construct(InspectTopicInterface $inspectTopicRepository )
    {
        $this->inspectTopicRepository = $inspectTopicRepository;
    }

    public function list(Request $request)
    {
        $postData = $request->all();
        $id = $request->id;
        // dd($request->id);
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->inspectTopicRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->inspectTopicRepository->getAllInspectTopics($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->inspectTopicRepository->paginate($param);
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
            "method" => ["required"],
            "category_id" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_inspect_topic_ = InspectTopic::create([
            "name" => $data['name'],
            "method" => $data['method'],
            "category_id" => $data['category_id'],
            "record_status" => 1
        ]);
        return $create_inspect_topic_;
    }

    public function update(Request $request)
    {
            $data = $request->all();
            $edit_inspect_topic_ = $this->inspectTopicRepository->update($request->id, $data);
            return $edit_inspect_topic_;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->inspectTopicRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_inspect_topic_ = $this->inspectTopicRepository->find($data['id']);
        return $data_inspect_topic_;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_inspect_topic_ = $this->inspectTopicRepository->update($request->id,$data);
        return $update_inspect_topic_;
    }
}
