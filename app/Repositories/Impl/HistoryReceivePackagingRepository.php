<?php


namespace App\Repositories\Impl;


use App\Models\HistoryReceivePackaging;

use App\Repositories\HistoryReceivePackagingInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryReceivePackagingRepository extends BaseRepository implements HistoryReceivePackagingInterface
{

    protected $model;

    public function __construct(HistoryReceivePackaging $model)
    {
       parent::__construct($model);
    }

    public function historyReceivePackaging($id): Collection

    {
        return $this->model->with('brandVendor','logisticVendor','historypackagingLots','historypackagingLots.packaging','historypackagingLots.company')
        ->select('*')
        ->where('receive_packaging_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }





}
