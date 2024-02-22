<?php


namespace App\Repositories\Impl;

use App\Models\MaterialCutReturn;
use App\Models\MaterialLot;
use App\Repositories\MaterialCutReturnInterface;
use App\Repositories\MaterialLotInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MaterialCutReturnRepository extends BaseRepository implements MaterialCutReturnInterface
{

    protected $model;

    public function __construct(MaterialCutReturn $model)
    {
        parent::__construct($model);
    }

    public function getCutReturnById($material_lot_id): Collection
    {
        $material_cut_returns = $this->model->where('material_lot_id', $material_lot_id)->get();
        return $material_cut_returns;
    }

    public function getAllMaterialRequsitionLot($id): Collection
    {
        $materialRequsition_lots = $this->model->with('materialLot.material')
            ->select('*')

            ->where('requsition_material_id', '=', $id)

            ->get();
        return $materialRequsition_lots;
    }

    public function all(): Collection
    {
        $data = $this->model->with('materialLot')->get();
        return $data;
    }

    public function getData($param): Collection
    {
        $data = $this->model->with('materialLot')
            ->whereHas('materialLot', function ($q) use ($param) {
                $q->where('material_id', '=', $param['mat_search']);
            })->get();
        return $data;
    }
}
