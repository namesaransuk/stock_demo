<?php


namespace App\Repositories\Impl;

use App\Models\MaterialCutReturn;
use App\Models\MaterialLot;
use App\Models\PackagingCutReturn;
use App\Repositories\MaterialCutReturnInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\PackagingCutReturnInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PackagingCutReturnRepository extends BaseRepository implements PackagingCutReturnInterface
{

    protected $model;

    public function __construct(PackagingCutReturn $model)
    {
       parent::__construct($model);
    }

    public function getCutReturnById($packaging_lot_id)
    {
        $packaging_cut_returns = $this->model->where('packaging_lot_id', '=', $packaging_lot_id)
            ->select('*')
            ->get();
        return $packaging_cut_returns;
    }

    public function getAllPackagingRequsitionLot($id): Collection
    {
        $packagingRequsition_lots = $this->model->with('packagingLot.packaging')
            ->select('*')

            ->where('requsition_packaging_id','=',$id)

            ->get();
        return $packagingRequsition_lots;
    }

    public function getData($param) : Collection
    {
        $data = $this->model->with('packagingLot')
        ->whereHas('packagingLot', function($q) use($param){
            $q->where('packaging_id', '=', $param['mat_search']);
        })->get();
        return $data;
    }








}
