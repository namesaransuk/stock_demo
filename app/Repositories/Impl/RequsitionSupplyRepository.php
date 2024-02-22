<?php


namespace App\Repositories\Impl;

use App\Models\RequsitionSupply;
use App\Repositories\RequsitionSupplyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RequsitionSupplyRepository extends BaseRepository implements RequsitionSupplyInterface
{

    protected $model;

    public function __construct(RequsitionSupply $model)
    {
       parent::__construct($model);
    }
    public function count($param,$paper_status): int
    {
        return DB::table('requsition_supplies')
        ->select(DB::raw('count(*) as requsition_supplies_count'))
        ->where('paper_status','=',$paper_status)
        ->where('company_id','=',$param['company_id'])
        ->count();
    }

    public function paginate($param,$paper_status): Collection
    {
        return $this->model->with('supplyCut','stockUser','supplyCut.supplyLot.supply')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$paper_status)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->orWhere('detail', 'like', '%' .$param['searchValue'] . '%');
                $q->orWhereHas('supplyCut.supplyLot.supply',function($q2) use ($param) {
                    $q2->where('name', 'like', '%' .$param['searchValue'] . '%'); //ของ supply
                    // $q2->orWhere('qty', 'like', '%' .$param['searchValue'] . '%'); //ของ Lot
            });
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllRequsitionSupply($param,$name,$paper_status): Collection
    {
        $receive_supplies = DB::table('requsition_supplies')
            ->select('*')
            ->where('paper_status','=',$paper_status)
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('company_id','=',$param['company_id'])
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_supplies;
    }





}
