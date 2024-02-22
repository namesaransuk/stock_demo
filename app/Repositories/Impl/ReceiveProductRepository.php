<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Models\ReceivePackaging;
use App\Models\ReceiveProduct;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\ReceiveProductInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReceiveProductRepository extends BaseRepository implements ReceiveProductInterface
{

    protected $model;

    public function __construct(ReceiveProduct $model)
    {
       parent::__construct($model);
    }
    public function count($param,$paper_status,$inspect_ready): int
    {
        return DB::table('receive_products')
        ->select(DB::raw('count(*) as receive_products_count'))
        ->where('paper_status','=',$paper_status)
        ->where('inspect_ready','=',$inspect_ready)
        ->where('company_id','=',$param['company_id'])
        ->count();
    }

    public function paginate($param,$paper_status,$inspect_ready): Collection
    {
        return $this->model->with('productionUser','productLots.product','stockUser')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$paper_status)
            ->where('inspect_ready','=',$inspect_ready)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');

            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllReceiveProducts($param,$name,$paper_status,$inspect_ready): Collection
    {
        $receive_products = DB::table('receive_products')
            ->select('*')
            ->where('paper_status','=',$paper_status)
            ->where('inspect_ready','=',$inspect_ready)
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('company_id','=',$param['company_id'])
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_products;
    }

    public function getTemplateDetailByTemplateID($id): Collection
    {
        return DB::table('inspect_template_details')
            ->leftJoin('inspect_topics', 'inspect_topics.id', '=', 'inspect_template_details.inspect_topic_id')
            ->select('*')
            ->where('inspect_template_id','=',$id)
            ->get();
    }

    public function countPending(): int
    {
        return DB::table('receive_products')
        ->select(DB::raw('count(*) as receive_product_count'))
        ->where('paper_status','=',2)
        ->count();
    }

    public function paginatePendingListReceiveProducts($param): Collection
    {
        return $this->model->with('productLots.product','productionUser','stockUser')->orderBy($param['columnName'],$param['columnSortOrder'])
            ->where(function($q) use ($param) {
                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->where('paper_status', '=', 2);
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllPendingReceiveProducts($name): Collection
    {
        $receive_products = DB::table('receive_products')
            ->select('*')
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('paper_no', '=', 2)
            ->get();
        return $receive_products;
    }

}
