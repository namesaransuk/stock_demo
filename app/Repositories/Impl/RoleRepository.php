<?php


namespace App\Repositories\Impl;

use App\Models\Role;
use App\Repositories\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoleRepository extends BaseRepository implements RoleInterface
{

    protected $model;

    public function __construct(Role $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('roles')
        ->select(DB::raw('count(*) as roles_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('name', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllRoles($name): Collection
    {
        $roles = DB::table('roles')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $roles;
    }

}
