<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\CompanyInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct(CompanyInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function companiesList(Request $request)
    {
        $result = $this->companyRepository->all();
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
        $totalRecordswithFilter = $totalRecords = $this->companyRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->companyRepository->getAllCompany($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->companyRepository->paginate($param);

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
            "name_th" => ["required"],
            "name_en" => ["required"],
            "email" => ["required"],
            "address_th" => ["required"],
            "address_en" => ["required"],
            "website" => ["required"],
            "contact_number" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        return response()->json(['success' => 'Added new records.']);
    }

    public function create(Request $request)
    {
        // dd($request);
        $data = $request->all();
        if ($request->file('logo')) {
            $logo = save_image($request->file('logo'), 500, '/company_logo/');
        };
        $create_company = Company::create([
            "name_th" => $data['name_th'],
            "name_en" => $data['name_en'],
            "email" => $data['email'],
            "address_th" => $data['address_th'],
            "address_en" => $data['address_en'],
            "website" => $data['website'],
            "contact_number" => $data['contact_number'],
            "logo" => $logo,
            "record_status" => 1
        ]);
        return $data;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ($id) {
            $data = [
                'record_status' => 0
            ];
            $this->companyRepository->update($id, $data);
            $status = 1;
        }
        return ["status" => $status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();

        $data_company = $this->companyRepository->find($data['id']);
        return $data_company;
    }

    public function edit(Request $request)
    {
        $company = $this->companyRepository->find($request->id);

        $old_img = $company['logo'];
        // dd($request->file('logo'));
        if ($request->file('logo')) {
            $new_img = save_image($request->file('logo'), 500, '/company_logo/');
        };

        $data = $request->all();

        //เช็คชื่อเก่า เพื่ออัพเดท
        if (is_null($request->file('logo'))) {
            $data['logo'] = $old_img;
        } else {
            $data['logo'] = $new_img;
        }


        $update_company = $this->companyRepository->update($request->id, $data);
        return $update_company;
    }
}
