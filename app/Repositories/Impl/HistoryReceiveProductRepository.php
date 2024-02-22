<?php


namespace App\Repositories\Impl;


use App\Models\HistoryReceivePackaging;
use App\Models\HistoryReceiveProduct;
use App\Repositories\HistoryReceivePackagingInterface;
use App\Repositories\HistoryReceiveProductInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryReceiveProductRepository extends BaseRepository implements HistoryReceiveProductInterface
{

    protected $model;

    public function __construct(HistoryReceiveProduct $model)
    {
       parent::__construct($model);
    }

    public function historyReceiveProduct($id): Collection

    {
        return $this->model->with('historyproductLots','historyproductLots.category','historyproductLots.productUnit','historyproductLots.company','historyproductLots.unit','historyproductLots.product')
        ->select('*')
        ->where('receive_product_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }





}
