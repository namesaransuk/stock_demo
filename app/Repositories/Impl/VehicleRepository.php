<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\Packaging;
use App\Models\Vehicle;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\PackageInterface;
use App\Repositories\VehicleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VehicleRepository extends BaseRepository implements VehicleInterface
{

    protected $model;

    public function __construct(Vehicle $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('vehicles')
        ->select(DB::raw('count(*) as vehicles_count'))
        // ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->with('company')->orderBy($param['columnName'],$param['columnSortOrder'])
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {
                $q->where('brand', 'like', '%' .$param['searchValue'] . '%');
                $q->where('model', 'like', '%' .$param['searchValue'] . '%');
                $q->where('plate', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllVehicles($name): Collection
    {
        $vehicles = DB::table('vehicles')
            ->select('*')
            ->where('brand', 'like', '%' .$name . '%')
            // ->where('record_status','=',1)
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $vehicles;
    }

}
