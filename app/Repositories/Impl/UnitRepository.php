<?php


namespace App\Repositories\Impl;

use App\Models\Unit;
use App\Repositories\UnitInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UnitRepository extends BaseRepository implements UnitInterface
{

    protected $model;

    public function __construct(Unit $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('units')
        ->select(DB::raw('count(*) as units_count'))
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
    public function getAllunits($name): Collection
    {
        $units = DB::table('units')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $units;
    }

}
