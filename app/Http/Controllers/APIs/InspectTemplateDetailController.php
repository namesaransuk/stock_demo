<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\InspectTemplateDetail;
use App\Repositories\InspectTemplateDetailInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InspectTemplateDetailController extends Controller
{
    private $inspectTemplateDetailRepository;

    public function __construct(InspectTemplateDetailInterface $inspectTemplateDetailRepository )
    {
        $this->inspectTemplateDetailRepository = $inspectTemplateDetailRepository;
    }

    public function list(Request $request)
    {
        $postData = $request->all();
        $id = $request->id;
        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->inspectTemplateDetailRepository->count($id);
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->inspectTemplateDetailRepository->getAllInspectTemplateDetails($id,$searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->inspectTemplateDetailRepository->paginate($id,$param);

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
            // "inspect_template_id" => ["required"],
            // "inspect_topic_type_id" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        // $create_inspect_template_detail = $this->inspectTemplateDetailRepository->create($data);

        $create_inspect_template_detail = InspectTemplateDetail::create([
            "inspect_template_id" => $data['inspect_template_id'],
            "inspect_topic_id" => $data['inspect_topic_id'],
        ]);

        return $create_inspect_template_detail;
    }

    public function update(Request $request)
    {
            $data = $request->all();
            $edit_inspect_template_detail = $this->inspectTemplateDetailRepository->update($request->id, $data);
            return $edit_inspect_template_detail;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $this->inspectTemplateDetailRepository->delete($id);
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_inspect_template_detail = $this->inspectTemplateDetailRepository->find($data['id']);
        return $data_inspect_template_detail;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $update_inspect_template_detail = $this->inspectTemplateDetailRepository->update($request->id,$data);
        return $update_inspect_template_detail;
    }
}
