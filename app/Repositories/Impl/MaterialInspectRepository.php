<?php


namespace App\Repositories\Impl;
use App\Models\MaterialInspect;
use App\Repositories\MaterialInspectInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MaterialInspectRepository extends BaseRepository implements MaterialInspectInterface
{

    protected $model;

    public function __construct(MaterialInspect $model)
    {
       parent::__construct($model);
    }

    public function getInspectDetailByMaterialLotID($id): Collection
    {
        return $this->model->with('materialInspectDetails')
            ->where('material_lot_id','=',$id)
            ->select('*')
            ->get();

    }







}
