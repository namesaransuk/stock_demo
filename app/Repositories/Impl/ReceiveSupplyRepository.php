<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Models\ReceivePackaging;
use App\Models\ReceiveSupply;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\ReceiveSupplyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReceiveSupplyRepository extends BaseRepository implements ReceiveSupplyInterface
{

    protected $model;

    public function __construct(ReceiveSupply $model)
    {
       parent::__construct($model);
    }
    public function count($param,$paper_status): int
    {
        return DB::table('receive_supplies')
        ->select(DB::raw('count(*) as receive_supplies_count'))
        ->where('paper_status','=',$paper_status)
        ->where('company_id','=',$param['company_id'])
        ->count();
    }

    public function paginate($param,$paper_status): Collection
    {
        return $this->model->with('supplyLots.supply','stockUser')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$paper_status)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->orWhereHas('supplyLots.supply',function($q2) use ($param) {
                        $q2->where('name', 'like', '%' .$param['searchValue'] . '%'); //ของ supply
                        // $q2->orWhere('qty', 'like', '%' .$param['searchValue'] . '%'); //ของ Lot
                });
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllReceiveSupplies($param,$name,$paper_status): Collection
    {
        $receive_supplies = DB::table('receive_supplies')
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
        return DB::table('receive_supplies')
        ->select(DB::raw('count(*) as receive_supply_count'))
        ->where('paper_status','=',2)
        ->count();
    }

    public function paginatePendingListReceiveSupplies($param): Collection
    {
        return $this->model->with('supplyLots.supply','stockUser')->orderBy($param['columnName'],$param['columnSortOrder'])
            ->where(function($q) use ($param) {
                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->where('paper_status', '=', 2);
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllPendingReceiveSupplies($name): Collection
    {
        $receive_supplies = DB::table('receive_supplies')
            ->select('*')
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('paper_no', '=', 2)
            ->get();
        return $receive_supplies;
    }

}
