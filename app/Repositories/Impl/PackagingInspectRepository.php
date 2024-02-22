<?php


namespace App\Repositories\Impl;
use App\Models\MaterialLot;
use App\Models\PackagingInspect;
use App\Models\PackagingLot;
use App\Repositories\MaterialLotInterface;
use App\Repositories\PackagingInspectInterface;
use App\Repositories\PackagingLotInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PackagingInspectRepository extends BaseRepository implements PackagingInspectInterface
{

    protected $model;

    public function __construct(PackagingInspect $model)
    {
       parent::__construct($model);
    }
    public function getInspectDetailByPackagingLotID($id): Collection
    {
        return $this->model->with('packagingInspectDetails')
            ->where('packaging_lot_id','=',$id)
            ->select('*')
            ->get();
    }









}
