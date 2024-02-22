<?php


namespace App\Repositories\Impl;

use App\Models\InspectTopicUnit;
use App\Models\ProductUnit;
use App\Repositories\InspectTopicUnitInterface;
use App\Repositories\ProductUnitInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductUnitRepository extends BaseRepository implements ProductUnitInterface
{

    protected $model;

    public function __construct(ProductUnit $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('product_units')
        ->select(DB::raw('count(*) as product_units_count'))
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
    public function getAllProductUnits($name): Collection
    {
        $product_units = DB::table('product_units')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $product_units;
    }

}
