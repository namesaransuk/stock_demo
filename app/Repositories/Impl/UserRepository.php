<?php


namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserInterface
{

    protected $model;

    public function __construct(User $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('users')
        ->select(DB::raw('count(*) as users_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->with('employee.company','userRoles.role')
        ->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('email', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllusers($name): Collection
    {
        $users = DB::table('users')
            ->select('*')
            ->where('record_status','=',1)
            ->where('email', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $users;
    }

    public function getUserInfo($id): Collection
    {
        $users = DB::table('users')
            ->select('*')
            ->join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('record_status','=',1)
            ->where('users.id','=',$id)
            ->get();
        return $users;
    }

}
