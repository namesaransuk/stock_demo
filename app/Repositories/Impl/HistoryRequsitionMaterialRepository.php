<?php


namespace App\Repositories\Impl;

use App\Models\HistoryReceiveMaterial;
use App\Models\HistoryRequsitionMaterial;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Repositories\HistoryReceiveMaterialInterface;
use App\Repositories\HistoryRequsitionMaterialInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryRequsitionMaterialRepository extends BaseRepository implements HistoryRequsitionMaterialInterface
{

    protected $model;

    public function __construct(HistoryRequsitionMaterial $model)
    {
       parent::__construct($model);
    }

    public function historyRequsitionMaterial($id) : Collection
    {
        return $this->model->with('historymaterialcutreturn','historymaterialcutreturn.materialLot','historymaterialcutreturn.materialLot.material')
        ->select('*')
        ->where('requsition_material_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }





}
