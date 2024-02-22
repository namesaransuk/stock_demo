<?php


namespace App\Repositories\Impl;

use App\Models\RequsitionProduct;
use App\Repositories\RequsitionProductInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RequsitionProductRepository extends BaseRepository implements RequsitionProductInterface
{

    protected $model;

    public function __construct(RequsitionProduct $model)
    {
       parent::__construct($model);
    }
    public function count($param,$paper_status,$ins_cut): int
    {
        return DB::table('requsition_products')
        ->select(DB::raw('count(*) as requsition_products_count'))
        ->where('ins_cut','=',$ins_cut)
        ->where('paper_status','=',$paper_status)
        ->where('company_id','=',$param['company_id'])
        ->count();
    }

    public function paginate($param,$paper_status,$ins_cut): Collection
    {
        return $this->model->with('productCuts','stockUser','productCuts.productLot.product')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$paper_status)
            ->where('ins_cut','=',$ins_cut)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->orWhere('recap', 'like', '%' .$param['searchValue'] . '%');

            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllRequsitionProduct($param,$name,$paper_status,$ins_cut): Collection
    {
        $receive_products = DB::table('requsition_products')
            ->select('*')
            ->where('paper_status','=',$paper_status)
            ->where('ins_cut','=',$ins_cut)
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('company_id','=',$param['company_id'])
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_products;
    }





}
