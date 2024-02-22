<?php


namespace App\Repositories\Impl;
use App\Models\MaterialLot;
use App\Models\PackagingLot;
use App\Models\ProductLot;
use App\Repositories\MaterialLotInterface;
use App\Repositories\PackagingLotInterface;
use App\Repositories\ProductLotInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductLotRepository extends BaseRepository implements ProductLotInterface
{

    protected $model;

    public function __construct(ProductLot $model)
    {
       parent::__construct($model);
    }

    public function getAllProductLot($id): Collection
    {
        $product_lots = $this->model->with('productUnit','company','unit','product')
            ->select('*')
            // ->leftJoin('categories', 'categories.id', '=', 'product_lots.category_id')
            // ->leftJoin('companies', 'companies.id', '=', 'product_lots.company_id')
            // ->leftJoin('units', 'units.id', '=', 'product_lots.unit_id')
            // ->leftJoin('product_units', 'product_units.id', '=', 'product_lots.product_unit_id')
            ->where('receive_product_id','=',$id)
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $product_lots;
    }

    public function getLotRemainById($id): Collection
    {
        return $this->model->selectRaw(" *, getBalanceProductLotByProductLotID(product_lots.id) as lotremain")
            ->where('product_lots.product_id','=',"$id")
            ->whereRaw('getBalanceProductLotByProductLotID(product_lots.id) != ?',[0.00])
            ->get();
    }

    public function getData($param) : Collection
    {
        $data = $this->model->with('product')
        ->where('product_lots.product_id','=',$param['mat_search'])
        ->get();
        return $data;
    }






}
