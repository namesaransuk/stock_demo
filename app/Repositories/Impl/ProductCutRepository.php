<?php


namespace App\Repositories\Impl;

use App\Models\ProductCut;
use App\Models\ProductLot;
use App\Repositories\ProductCutInterface;
use App\Repositories\ProductLotInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductCutRepository extends BaseRepository implements ProductCutInterface
{

    protected $model;

    public function __construct(ProductCut $model)
    {
       parent::__construct($model);
    }

    public function getCutReturnById($product_lot_id){
        $product_cut_returns = $this->model->where('product_lot_id', '=', $product_lot_id)
            ->select('*')
            ->get();
        return $product_cut_returns;
    }

    public function getAllProductRequsitionLot($id): Collection
    {
        $productRequsition_lots = $this->model->with('productLot.product')
            ->select('*')
            ->where('requsition_product_id','=',$id)
            ->get();
        return $productRequsition_lots;
    }

    public function getData($param) : Collection
    {
        $data = $this->model->with('productLot')
        ->whereHas('productLot', function($q) use($param){
            $q->where('product_id', '=', $param['mat_search']);
        })->get();
        return $data;
    }








}
