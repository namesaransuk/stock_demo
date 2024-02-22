<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialType;
use App\Models\PackagingCutReturn;
use App\Models\ReceiveMaterial;
use App\Models\ReceivePackaging;
use App\Models\ReceiveProduct;
use App\Models\RequsitionMaterial;
use App\Models\RequsitionPackaging;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\ReceiveProductInterface;
use App\Repositories\RequsitionMaterialInterface;
use App\Repositories\RequsitionPackagingInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RequsitionPackagingRepository extends BaseRepository implements RequsitionPackagingInterface
{

    protected $model;

    public function __construct(RequsitionPackaging $model)
    {
       parent::__construct($model);
    }

    public function countClaim($param): int
    {
        return DB::table('packaging_cut_returns')
        ->select(DB::raw('count(*) as claim_count'))
        ->where('action','=',3)
        ->count();
    }

    public function paginateClaim($param)
    {
        // dd(PackagingCutReturn::all());

        $data = PackagingCutReturn::with('requsitionPackaging','packagingLot','packagingLot.packaging')->orderBy($param['columnName'],$param['columnSortOrder'])
            ->where('action','=',3)
            ->whereHas('packagingLot', function($q) use($param){
                $q->where('company_id', '=', $param['company_id']);
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();


        return $data;


    }

    public function count($param,$paper_status,$ins_return,$ins_cut): int
    {
        return DB::table('requsition_packagings')
        ->select(DB::raw('count(*) as requsition_packagings_count'))
        ->where('paper_status','=',$paper_status)
        ->where('ins_return','=',$ins_return)
        ->where('ins_cut','=',$ins_cut)
        ->where('company_id','=',$param['company_id'])
        ->count();
    }

    public function paginate($param,$paper_status,$ins_return,$ins_cut): Collection
    {
        // dd(PackagingCutReturn::all());

        return $this->model->with('packagingCutReturns','stockUser','procurementUser','productionUser','packagingCutReturns.packagingLot.packaging')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$paper_status)
            ->where('ins_return','=',$ins_return)
            ->where('ins_cut','=',$ins_cut)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->orWhere('product_name', 'like', '%' .$param['searchValue'] . '%');

            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();


    }
    public function getAllRequsitionPackaging($param,$name,$paper_status,$ins_return,$ins_cut): Collection
    {
        $receive_products = DB::table('requsition_packagings')
            ->select('*')
            ->where('paper_status','=',$paper_status)
            ->where('ins_return','=',$ins_return)
            ->where('ins_cut','=',$ins_cut)
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
        $data = $this->model->with('packagingCutReturns','stockUser.employee','procurementUser.employee','productionUser.employee','packagingCutReturns.packagingLot.packaging')
            ->where('id','=',$id)
            ->select('*')
            ->get();

        return $data;
    }





}
