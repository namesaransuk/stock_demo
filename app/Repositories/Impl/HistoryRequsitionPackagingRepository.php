<?php


namespace App\Repositories\Impl;

use App\Models\HistoryReceiveMaterial;
use App\Models\HistoryRequsitionMaterial;
use App\Models\HistoryRequsitionPackaging;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Repositories\HistoryReceiveMaterialInterface;
use App\Repositories\HistoryRequsitionMaterialInterface;
use App\Repositories\HistoryRequsitionMPackagingInterface;
use App\Repositories\HistoryRequsitionPackagingInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryRequsitionPackagingRepository extends BaseRepository implements HistoryRequsitionPackagingInterface
{

    protected $model;

    public function __construct(HistoryRequsitionPackaging $model)
    {
       parent::__construct($model);
    }

    public function historyRequsitionPackaging($id) : Collection
    {
        return $this->model->with('historypackagingcutreturn','historypackagingcutreturn.packagingLot','historypackagingcutreturn.packagingLot.packaging')
        ->select('*')
        ->where('requsition_packaging_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }





}
