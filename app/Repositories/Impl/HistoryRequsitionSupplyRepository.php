<?php


namespace App\Repositories\Impl;

use App\Models\HistoryRequsitionSupply;
use App\Repositories\HistoryRequsitionSupplyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryRequsitionSupplyRepository extends BaseRepository implements HistoryRequsitionSupplyInterface
{

    protected $model;

    public function __construct(HistoryRequsitionSupply $model)
    {
       parent::__construct($model);
    }

    public function historyRequsitionSupply($id) : Collection
    {
        return $this->model->with('historysupplycut','historysupplycut.supplyLot.company','historysupplycut.supplyLot.supply','createUser.employee.prefix','updateUser.employee.prefix',)
        ->select('*')
        ->where('requsition_supply_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }







}
