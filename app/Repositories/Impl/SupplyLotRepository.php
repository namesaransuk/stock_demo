<?php


namespace App\Repositories\Impl;
use App\Models\PackagingLot;
use App\Models\SupplyLot;
use App\Repositories\PackagingLotInterface;
use App\Repositories\SupplyLotInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SupplyLotRepository extends BaseRepository implements SupplyLotInterface
{

    protected $model;

    public function __construct(SupplyLot $model)
    {
       parent::__construct($model);
    }

    public function getAllSupplyLot($id): Collection
    {
        $supply_lots = $this->model->with('company','supply')
            ->select('*')
            ->where('receive_supply_id','=',$id)
            ->get();
        return $supply_lots;
    }

    public function getSupplyLotBySupplyId($id): Collection
    {
       $supply_lots = DB::table('supply_lots')
            ->select('*')
            ->where('supply_id','=',$id)
            ->where('action','=',2)
            ->get();
        return $supply_lots;
    }

    public function updateActionByReceiveID($id)
    {
        $supply_lots = DB::table('supply_lots')
                        ->where('receive_supply_id', $id)
                        ->update(['action' => 2]);
        return $supply_lots;
    }

    public function getLotRemainById($id): Collection
    {
        return $this->model->selectRaw(" *, getBalanceSupplyLotBySupplyLotID(supply_lots.id) as lotremain")
            ->where('supply_lots.supply_id','=',"$id")
            ->whereRaw('getBalanceSupplyLotBySupplyLotID(supply_lots.id) != ?',[0.00])
            ->get();
    }

    public function getData($param) : Collection
    {
        $data = $this->model->with('supply')
        ->where('supply_lots.supply_id','=',$param['mat_search'])
        ->get();
        return $data;
    }






}
