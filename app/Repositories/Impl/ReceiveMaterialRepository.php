<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReceiveMaterialRepository extends BaseRepository implements ReceiveMaterialInterface
{

    protected $model;

    public function __construct(ReceiveMaterial $model)
    {
        parent::__construct($model);
    }

    public function count($param, $paper_status, $inspect_ready): int
    {
        return DB::table('receive_materials')
            ->select(DB::raw('count(*) as receive_material_count'))
            ->where('paper_status', '=', $paper_status)
            ->where('inspect_ready', '=', $inspect_ready)
            ->where('company_id', '=', $param['company_id'])
            ->count();
    }

    public function paginate($param, $paper_status, $inspect_ready): Collection
    {
        return $this->model->with('materialLots.company', 'materialLots.material', 'stockUser', 'auditUser', 'brandVendor', 'logisticVendor')->orderBy($param['columnName'], $param['columnSortOrder'])

            ->where('paper_status', '=', $paper_status)
            ->where('inspect_ready', '=', $inspect_ready)
            ->where('company_id', '=', $param['company_id'])

            ->where(function ($q) use ($param) {

                $q->where('paper_no', 'like', '%' . $param['searchValue'] . '%');
                $q->orWhereHas('brandVendor', function ($q2) use ($param) {
                    $q2->where('brand', 'like', '%' . $param['searchValue'] . '%');
                });
                $q->orWhereHas('logisticVendor', function ($q2) use ($param) {
                    $q2->where('brand', 'like', '%' . $param['searchValue'] . '%');
                });
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }

    public function printMaterials($company_id, $paper_status, $inspect_ready): Collection
    {
        $receive_materials = $this->model->with('materialLots.company', 'materialLots.material', 'stockUser', 'auditUser', 'brandVendor', 'logisticVendor')
            ->select('*')
            ->where('company_id', '=', $company_id)
            ->where('paper_status', '=', $paper_status)
            ->where('inspect_ready', '=', $inspect_ready)
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_materials;
    }


    public function getAllReceiveMaterials($param, $name, $paper_status, $inspect_ready): Collection
    {
        $receive_materials = DB::table('receive_materials')
            ->select('*')
            ->with('brandVendor')
            ->where('paper_no', 'like', '%' . $name . '%')
            ->where('paper_status', '=', $paper_status)
            ->where('inspect_ready', '=', $inspect_ready)
            ->where('company_id', '=', $param['company_id'])

            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_materials;
    }

    public function findAllById($id)
    {
        return $this->model->with('materialLots')->select('*')->where('id', '=', $id)->get();
    }

    public function countPending(): int
    {
        return DB::table('receive_materials')
            ->select(DB::raw('count(*) as receive_material_count'))
            ->where('paper_status', '=', 3)
            ->count();
    }

    public function paginatePendingListReceiveMaterials($param): Collection
    {
        return $this->model->with('materialLots.company', 'materialLots.material', 'stockUser', 'auditUser', 'brandVendor', 'logisticVendor')->orderBy($param['columnName'], $param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where(function ($q) use ($param) {

                $q->where('paper_no', 'like', '%' . $param['searchValue'] . '%');
                $q->where('paper_status', '=', 3);
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllPendingReceiveMaterials($name): Collection
    {
        $receive_materials = DB::table('receive_materials')
            ->select('*')
            ->where('paper_no', 'like', '%' . $name . '%')
            ->where('paper_no', '=', 3)
            ->get();
        return $receive_materials;
    }

    public function findMaterialLotById($id)
    {
        $material_lot = DB::table('material_lots')
            ->leftJoin('materials', 'material_lots.material_id', '=', 'materials.id')
            ->leftJoin('material_types', 'materials.material_type_id', '=', 'material_types.id')
            ->select("*")
            ->where('material_lots.id', '=', $id)
            ->get();
        return $material_lot;
    }

    public function getTemplateDetailByTemplateID($id): Collection
    {
        return DB::table('inspect_template_details')
            ->leftJoin('inspect_topics', 'inspect_topics.id', '=', 'inspect_template_details.inspect_topic_id')
            ->select('*')
            ->where('inspect_template_id', '=', $id)
            ->get();
    }
}
