<?php


namespace App\Repositories\Impl;

use App\Models\MaterialUnit;
use App\Repositories\MaterialUnitInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MaterialUnitRepository extends BaseRepository implements MaterialUnitInterface
{

    protected $model;

    public function __construct(MaterialUnit $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('material_units')
        ->select(DB::raw('count(*) as material_units_count'))
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

    public function getAllmaterialUnits($name):Collection
    {
        $material_units = DB::table('material_units')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $material_units;
    }

}
