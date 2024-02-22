<?php


namespace App\Repositories\Impl;

use App\Models\HistoryRequsitionProduct;
use App\Repositories\HistoryRequsitionProductInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HistoryRequsitionProductRepository extends BaseRepository implements HistoryRequsitionProductInterface
{

    protected $model;

    public function __construct(HistoryRequsitionProduct $model)
    {
       parent::__construct($model);
    }

    public function historyRequsitionProduct($id) : Collection
    {
        return $this->model->with('historyproductcut','historyproductcut.productLot.unit','historyproductcut.productLot.product','createUser.employee.prefix','updateUser.employee.prefix',)
        ->select('*')
        ->where('requsition_product_id','=',$id)
        ->orderBy('edit_times', 'desc')
        ->get();
    }







}
