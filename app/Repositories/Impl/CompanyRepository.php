<?php


namespace App\Repositories\Impl;

use App\Models\Company;
use App\Repositories\CompanyInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CompanyRepository extends BaseRepository implements CompanyInterface
{

    protected $model;

    public function __construct(Company $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('companies')
        ->select(DB::raw('count(*) as companies_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('name_th', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllCompany($name): Collection
    {
        $companies = DB::table('companies')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name_th', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $companies;
    }

}
