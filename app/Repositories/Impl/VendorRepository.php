<?php


namespace App\Repositories\Impl;


use App\Models\Vendor;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\PackageInterface;
use App\Repositories\VendorInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VendorRepository extends BaseRepository implements VendorInterface
{

    protected $model;

    public function __construct(Vendor $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('vendors')
        ->select(DB::raw('count(*) as packaging_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('brand', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllVendors($name): Collection
    {
        $vendors = DB::table('vendors')
            ->select('*')
            ->where('brand', 'like', '%' .$name . '%')
            ->where('record_status','=',1)
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $vendors;
    }

}
