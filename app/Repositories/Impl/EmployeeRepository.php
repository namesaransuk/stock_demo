<?php


namespace App\Repositories\Impl;

use App\Models\Employee;
use App\Repositories\EmployeeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository implements EmployeeInterface
{

    protected $model;

    public function __construct(Employee $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('employees')
        ->select(DB::raw('count(*) as employees_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->with('prefix','company')
        ->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('fname', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllemployees($name): Collection
    {
        $employees = DB::table('employees')
            ->select('*')
            ->where('record_status','=',1)
            ->where('fname', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $employees;
    }

}
