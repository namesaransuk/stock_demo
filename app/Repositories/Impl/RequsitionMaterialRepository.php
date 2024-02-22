<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\ReceiveMaterial;
use App\Models\ReceivePackaging;
use App\Models\ReceiveProduct;
use App\Models\RequsitionMaterial;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\ReceiveProductInterface;
use App\Repositories\RequsitionMaterialInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RequsitionMaterialRepository extends BaseRepository implements RequsitionMaterialInterface
{

    protected $model;

    public function __construct(RequsitionMaterial $model)
    {
       parent::__construct($model);
    }

    public function count($param,$id,$ins_cut,$ins_return): int
    {
        return DB::table('requsition_materials')
        ->where('paper_status','=',$id)
        ->where('ins_return','=',$ins_return)
        ->where('ins_cut','=',$ins_cut)
        ->where('company_id','=',$param['company_id'])
        ->select(DB::raw('count(*) as requsition_materials_count'))
        ->count();
    }

    public function paginate($param,$id,$ins_cut,$ins_return): Collection
    {
        return $this->model->with('materialCutReturns.updateBy.employee','materialCutReturns.createBy.employee','stockUser','procurementUser','productionUser','materialCutReturns.materialLot.material')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$id)
            ->where('ins_return','=',$ins_return)
            ->where('ins_cut','=',$ins_cut)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');

            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllRequsitionMaterial($param,$name,$id,$ins_cut,$ins_return): Collection
    {
        $receive_products = DB::table('requsition_materials')
            ->select('*')
            ->where('ins_cut','=',$ins_cut)
            ->where('ins_return','=',$ins_return)
            ->where('paper_status','=',$id)
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('company_id','=',$param['company_id'])
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_products;
    }

    public function requsitionDataForReport($id): Collection
    {
        $data = $this->model->with('materialCutReturns.updateBy.employee','materialCutReturns.createBy.employee','stockUser','procurementUser','productionUser','materialCutReturns.materialLot.material')
            ->where('id','=',$id)
            ->select('*')
            ->get();

        return $data;
    }

}
