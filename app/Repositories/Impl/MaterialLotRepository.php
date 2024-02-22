<?php


namespace App\Repositories\Impl;

use App\Models\MaterialLot;
use App\Repositories\MaterialLotInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MaterialLotRepository extends BaseRepository implements MaterialLotInterface
{

    protected $model;

    public function __construct(MaterialLot $model)
    {
        parent::__construct($model);
    }

    public function sumRemain($id)
    {
        return $this->model->where('material_id', '=', $id)
            ->sum('weight_total');
    }

    public function count($id): int
    {
        return DB::table('material_lots')
            ->select(DB::raw('count(*) as material_lots_count'))
            ->where('receive_material_id', '=', $id)
            ->count();
    }

    public function paginate($id, $param): Collection
    {
        return $this->model->with('material', 'company')->orderBy($param['columnName'], $param['columnSortOrder'])

            ->where('receive_material_id', '=', $id)
            ->where(function ($q) use ($param) {
                $q->where('lot', 'like', '%' . $param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllMaterialLot($id): Collection
    {
        $material_lots = $this->model
            // ->selectRaw('*,companies.id as company_id')
            // ->leftJoin('materials', 'materials.id', '=', 'material_lots.material_id')
            // ->leftJoin('companies', 'companies.id', '=', 'material_lots.company_id')
            ->where('receive_material_id', '=', $id)
            ->get();
        return $material_lots;
    }

    public function getMaterialLotByMaterialId($id): Collection
    {
        $material_lots = DB::table('material_lots')
            ->select('*')
            ->where('material_id', '=', $id)
            ->where('action', '=', '4')
            ->get();
        return $material_lots;
    }

    public function getLotRemainById($id): Collection
    {
        return $this->model->selectRaw(" *, DATE_FORMAT(exp, '%d/%m/%Y') as exp, getBalanceMaterialLotByMaterialLotID(material_lots.id) as lotremain")
            ->where('material_lots.material_id', '=', "$id")
            ->whereRaw('getBalanceMaterialLotByMaterialLotID(material_lots.id) != ?', [0.00])
            ->orderBy('exp', 'asc')
            ->get();
    }

    public function all(): Collection
    {
        $data = $this->model->with('material')->get();
        return $data;
    }

    public function getData($param): Collection
    {
        $data = $this->model->with('material')
            ->where('material_lots.material_id', '=', $param['mat_search'])
            ->get();
        return $data;
    }
}
