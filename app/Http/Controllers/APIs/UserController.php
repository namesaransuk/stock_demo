<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use App\Repositories\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserInterface $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    public function list(Request $request)
    {
        $postData = $request->all();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page

        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column email
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        // Total records
        $totalRecordswithFilter = $totalRecords = $this->userRepository->count();
        if (strlen($searchValue) > 0) {
            $totalRecordswithFilter = $this->userRepository->getAllUsers($searchValue)->count();
        }
        $param = [
            "columnName" => $columnName,
            "columnSortOrder" => $columnSortOrder,
            "searchValue" => $searchValue,
            "start" => $start,
            "rowperpage" => $rowperpage
        ];
        // Fetch records
        $records = $this->userRepository->paginate($param);

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
            "email" => ["required"],
            "password" => ["required"],
            "emp_id" => ["required"],
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
            return response()->json(['success'=>'Added new records.']);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_user = User::create([
            "email" => $data['email'],
            "password" => Hash::make($data['password']),
            "emp_id" => $data['emp_id'],
        ]);
        $create_user_role = UserRole::create([
            "user_id" => $create_user->id,
            "role_id" => $data['role_id'],
        ]);
        return $create_user;
    }

    public function update(Request $request)
    {
            $data = $request->all();
            $data += [
                "password" => Hash::make($data['password']),
            ];
            dd($data);
            $edit_user = $this->userRepository->update($request->id, $data);
            return $edit_user;
    }

    public function delete(Request $request)
    {
        $status = 0;
        $id = $request->id;
        if ( $id ) {
            $data = [
                'record_status' => 0
            ];
            $this->userRepository->update($id, $data);
            $status = 1;
        }
        return ["status"=>$status];
    }

    public function viewEdit(Request $request)
    {
        $data = $request->all();
        $data_user = $this->userRepository->getUserInfo($data['id']);
        return $data_user;
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $update_user = $this->userRepository->update($request->id,$data);
        return $update_user;
    }
}
