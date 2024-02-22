<?php


namespace App\Repositories\Impl;

use App\Models\SupplyCut;
use App\Models\SupplyLot;
use App\Repositories\SupplyCutInterface;
use App\Repositories\SupplyLotInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SupplyCutRepository extends BaseRepository implements SupplyCutInterface
{

    protected $model;

    public function __construct(SupplyCut $model)
    {
       parent::__construct($model);
    }

    public function getCutReturnById($supply_lot_id){
        $supply_cut_returns = $this->model->where('supply_lot_id', '=', $supply_lot_id)
            ->select('*')
            ->get();
        return $supply_cut_returns;
    }

    public function getAllSupplyRequsitionLot($id): Collection
    {
        $supplyRequsition_lots = $this->model->with('supplyLot.supply')
            ->select('*')
            ->where('requsition_supply_id','=',$id)
            ->get();
        return $supplyRequsition_lots;
    }

    public function getData($param) : Collection
    {
        $data = $this->model->with('supplyLot')
        ->whereHas('supplyLot', function($q) use($param){
            $q->where('supply_id', '=', $param['mat_search']);
        })->get();
        return $data;
    }








}
