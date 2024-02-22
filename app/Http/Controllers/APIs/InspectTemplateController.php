<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\InspectTemplate;
use App\Models\InspectTemplateDetail;
use App\Models\InspectTopic;
use App\Repositories\InspectTemplateDetailInterface;
use App\Repositories\InspectTemplateInterface;
use App\Repositories\InspectTopicInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InspectTemplateController extends Controller
{
    private $inspectTemplateRepository;
    private $inspectTemplateDetailRepository;
    private $inspectTopicRepository;

    public function __construct(InspectTemplateInterface $inspectTemplateRepository ,InspectTopicInterface $inspectTopicRepository, InspectTemplateDetailInterface $inspectTemplateDetailRepository)
    {
        $this->inspectTemplateRepository = $inspectTemplateRepository;
        $this->inspectTemplateDetailRepository = $inspectTemplateDetailRepository;
        $this->inspectTopicRepository = $inspectTopicRepository;
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
        $totalRecordswithFilter = $totalRecords = $this->inspectTemplateRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->inspectTemplateRepository->getAllInspectTemplates($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->inspectTemplateRepository->paginate($param);

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
        // dd($data);

        $create_inspect_topic_type = InspectTemplate::create([
            "name" => $data['name'],
            "category_id" => $data['category_id'],
            "record_status" => 1
        ]);
        foreach ($data['inspect'] as $inspect) {
            $create_inspect_template_detail = InspectTemplateDetail::create([
                "inspect_template_id" => $create_inspect_topic_type->id,
                "inspect_topic_id" => $inspect['inspect_topic_id'],
            ]);

        }
        return $create_inspect_topic_type;
    }

    public function update(Request $request)
    {

            $data = $request->all();
            $edit_inspect_topic_type = $this->inspectTemplateRepository->update($request->id, $data);
            return $edit_inspect_topic_type;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->inspectTemplateRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_inspect_topic_type = $this->inspectTemplateRepository->find($data['id']);
        return $data_inspect_topic_type;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        // dd($data);

        $delete_old_data = $this->inspectTemplateDetailRepository->deleteOldTemplateDetailByTemplateID($data['id']);
        if($data['countOld'] > 0){
            foreach ($data['inspectOld'] as $inspectOld) {
                $create_inspect_template_detail1 = InspectTemplateDetail::create([
                    "inspect_template_id" => $data['id'],
                    "inspect_topic_id" => $inspectOld['inspect_topic_id'],
                ]);
            }
        }
        if($data['count'] > 0){
            foreach ($data['inspect'] as $inspect) {
                $create_inspect_template_detail2 = InspectTemplateDetail::create([
                    "inspect_template_id" => $data['id'],
                    "inspect_topic_id" => $inspect['inspect_topic_id'],
                ]);
            }
        }
        $newData = [
            'name' => $data['name'],
            'category_id' => $data['category_id'],
        ];
        $update_name = $this->inspectTemplateRepository->update($data['id'],$newData);

        return $update_name;

    }

    public function getInspectTopic(Request $request)
    {
        $data = $request->all();
        $id = $this->inspectTemplateRepository->getTemplateByID($data['id']);
        $inspect_topics = $this->inspectTopicRepository->getInspectTopicByCategoryID($id[0]->category_id);
        // dd($inspect_topics);
        return $inspect_topics;
    }

    public function getTemplate(Request $request)
    {
        $data = $request->all();
        $template_detail = $this->inspectTemplateDetailRepository->getAllTemplateDetails($data['id']);
        return $template_detail;
    }

    public function getTemplateDetail(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $inspect_template_detail = $this->inspectTemplateDetailRepository->getAllTemplateDetails($data['id']);
        return $inspect_template_detail;
    }
}
