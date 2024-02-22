<?php


namespace App\Repositories\Impl;


use App\Models\HistoryReceivePackaging;
use App\Models\HistoryReceiveSupply;
use App\Repositories\HistoryReceivePackagingInterface;
use App\Repositories\HistoryReceiveSupplyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryReceiveSupplyRepository extends BaseRepository implements HistoryReceiveSupplyInterface
{

    protected $model;

    public function __construct(HistoryReceiveSupply $model)
    {
       parent::__construct($model);
    }

    public function historyReceiveSupply($id): Collection

    {
        return $this->model->with('brandVendor','stockUser.employee.prefix','createUser.employee.prefix','updateUser.employee.prefix','historySupplyLots.supply','historySupplyLots.company')
        ->select('*')
        ->where('receive_supply_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }





}
