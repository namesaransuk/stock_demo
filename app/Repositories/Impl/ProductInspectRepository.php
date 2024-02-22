<?php


namespace App\Repositories\Impl;
use App\Models\MaterialInspect;
use App\Models\ProductInspect;
use App\Repositories\MaterialInspectInterface;
use App\Repositories\ProductInspectInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductInspectRepository extends BaseRepository implements ProductInspectInterface
{

    protected $model;

    public function __construct(ProductInspect $model)
    {
       parent::__construct($model);
    }

    public function getInspectDetailByProductLotID($id): Collection
    {
        return $this->model->with('productInspectDetails')
            ->where('product_lot_id','=',$id)
            ->select('*')
            ->get();

    }







}
