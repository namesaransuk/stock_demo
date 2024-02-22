<?php


namespace App\Repositories\Impl;

use App\Models\Packaging;
use App\Models\PackagingType;
use App\Models\ReceivePackaging;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingTypeInterface;
use App\Repositories\ReceivePackagingInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReceivePackagingRepository extends BaseRepository implements ReceivePackagingInterface
{

    protected $model;

    public function __construct(ReceivePackaging $model)
    {
       parent::__construct($model);
    }
    public function count($param,$paper_status,$inspect_ready): int
    {
        return DB::table('receive_packagings')
        ->select(DB::raw('count(*) as receive_packagings_count'))
        ->where('paper_status','=',$paper_status)
        ->where('inspect_ready','=',$inspect_ready)
        ->where('company_id','=',$param['company_id'])
        ->count();
    }

    public function paginate($param,$paper_status,$inspect_ready): Collection
    {
        return $this->model->with('packagingLots.company','packagingLots.packaging','stockUser','auditUser','brandVendor','logisticVendor')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where('paper_status','=',$paper_status)
            ->where('inspect_ready','=',$inspect_ready)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->orWhereHas('brandVendor',function($q2) use ($param) {
                    $q2->where('brand','like', '%' .$param['searchValue'] . '%');
                });
                $q->orWhereHas('logisticVendor',function($q2) use ($param) {
                    $q2->where('brand','like', '%' .$param['searchValue'] . '%');
                });
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllReceivePackagings($param,$name,$paper_status,$inspect_ready): Collection
    {
        $receive_packagings = DB::table('receive_packagings')
            ->select('*')
            ->where('paper_status','=',$paper_status)
            ->where('inspect_ready','=',$inspect_ready)
            ->where('company_id','=',$param['company_id'])
            ->where('paper_no', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $receive_packagings;
    }


    public function findPackagingLotById($id)
    {
        $packaging_lot = DB::table('packaging_lots')
        ->leftJoin('packagings', 'packaging_lots.packaging_id', '=', 'packagings.id')
        ->leftJoin('packaging_types', 'packagings.packaging_type_id','=','packaging_types.id')
        ->select("*")
        ->where('packaging_lots.id','=',$id)
        ->get();
        return $packaging_lot;
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
        return DB::table('receive_packagings')
        ->select(DB::raw('count(*) as receive_packaging_count'))
        ->where('paper_status','=',3)
        ->count();
    }

    public function paginatePendingListReceivePackagings($param): Collection
    {
        return $this->model->with('packagingLots.company','packagingLots.packaging','stockUser','auditUser','brandVendor','logisticVendor')->orderBy($param['columnName'],$param['columnSortOrder'])

            // ->where('record_status','=',1)
            ->where(function($q) use ($param) {

                $q->where('paper_no', 'like', '%' .$param['searchValue'] . '%');
                $q->where('paper_status', '=', 3);
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllPendingReceivePackagings($name): Collection
    {
        $receive_packagings = DB::table('receive_packagings')
            ->select('*')
            ->where('paper_no', 'like', '%' .$name . '%')
            ->where('paper_status', '=', 3)
            ->get();
        return $receive_packagings;
    }


}
