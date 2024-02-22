<?php


namespace App\Repositories\Impl;

use App\Models\HistoryReceiveMaterial;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Repositories\HistoryReceiveMaterialInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryReceiveMaterialRepository extends BaseRepository implements HistoryReceiveMaterialInterface
{

    protected $model;

    public function __construct(HistoryReceiveMaterial $model)
    {
       parent::__construct($model);
    }

    public function historyReceiveMaterial($id) : Collection
    {
        return $this->model->with('brandVendor','logisticVendor','historymaterialLots','historymaterialLots.material','historymaterialLots.company')
        ->select('*')
        ->where('receive_material_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }





}
