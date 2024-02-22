<?php


namespace App\Repositories\Impl;
use App\Models\PackagingLot;
use App\Repositories\PackagingLotInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PackagingLotRepository extends BaseRepository implements PackagingLotInterface
{

    protected $model;

    public function __construct(PackagingLot $model)
    {
       parent::__construct($model);
    }

    public function getAllPackagingLot($id): Collection
    {
        $packaging_lots = DB::table('packaging_lots')
            ->select('*')
            ->leftJoin('packagings', 'packagings.id', '=', 'packaging_lots.packaging_id')
            ->leftJoin('companies', 'companies.id', '=', 'packaging_lots.company_id')
            ->where('receive_packaging_id','=',$id)
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $packaging_lots;
    }

    public function getPackagingLotByPackagingId($id): Collection
    {
        $packaging_lots = DB::table('packaging_lots')
            ->select('*')
            ->where('packaging_id','=',$id)
            ->where('action','=','4')
            ->get();
        return $packaging_lots;
    }

    public function getLotRemainById($id): Collection
    {
        return $this->model->with('packaging')->selectRaw(" *, DATE_FORMAT(exp, '%d/%m/%Y') as exp, getBalancePackagingLotByPackagingLotID(packaging_lots.id) as lotremain")
            ->where('packaging_lots.packaging_id','=',"$id")
            ->whereRaw('getBalancePackagingLotByPackagingLotID(packaging_lots.id) != ?',[0.00])
            ->orderBy('exp', 'asc')
            ->get();
    }

    public function getData($param) : Collection
    {
        $data = $this->model->with('packaging')
        ->where('packaging_lots.packaging_id','=',$param['mat_search'])
        ->get();
        return $data;
    }






}
