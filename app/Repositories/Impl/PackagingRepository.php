<?php


namespace App\Repositories\Impl;

use App\Models\Packaging;
use App\Models\PackagingCutReturn;
use App\Models\PackagingLot;
use App\Repositories\PackageInterface;
use App\Repositories\PackagingInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PackagingRepository extends BaseRepository implements PackagingInterface
{

    protected $model;
    private $value_lot;
    private $value_cut;

    public function __construct(Packaging $model, PackagingLot $value_lot, PackagingCutReturn $value_cut)
    {
       parent::__construct($model);
       $this->value_lot = $value_lot;
       $this->value_cut = $value_cut;
    }

    public function getAll() {
        return $this->model
        ->where('record_status', '=', '1')
        ->get();
    }

    public function countInventory($param): int
    {
        $get_month = (array_search($param['month_search'],monthAll())) + 1;

        $id_lot = [];
        $get_id_lot = PackagingLot::where('packaging_id',$param['mat_search'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if($param['year_search'] == -1){
            if($get_month == 13){
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->where('action', '=', '4')
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                );
            }else{
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->whereMonth('created_at', $get_month)
                ->where('action', '=', '4')
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->whereMonth('packaging_lots.created_at', $get_month)
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                );
            }
        }else{
            if($get_month == 13){
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->whereYear('created_at', $param['year_search'])
                ->where('action', '=', '4')
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->whereYear('packaging_lots.created_at', $param['year_search'])
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                );
            }else{
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->whereYear('created_at', $param['year_search'])
                ->whereMonth('created_at', $get_month)
                ->where('action', '=', '4')
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->whereYear('packaging_lots.created_at', $param['year_search'])
                ->whereMonth('packaging_lots.created_at', $get_month)
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                );
            }
        }

        $data = $get_lot->union($get_cut)->count();

        return $data;
    }
    public function paginateInventory($param): Collection
    {
        $get_month = (array_search($param['month_search'],monthAll())) + 1;

        $id_lot = [];
        $get_id_lot = PackagingLot::where('packaging_id',$param['mat_search'])->where('packaging_lots.company_id',$param['company_id'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if($param['year_search'] == -1){
            if($get_month == 13){
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->where('action', '=', '4')
                ->where('packaging_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'packaging_lots.created_at AS created_at',
                    'receive_packagings.paper_no AS paper_no',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->join('requsition_packagings', 'requsition_packagings.id', '=', 'packaging_cut_returns.requsition_packaging_id')
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    'packaging_cut_returns.action AS type',
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                    'packaging_cut_returns.created_at AS created_at',
                    'requsition_packagings.paper_no AS paper_no',
                );
            }else{
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->where('action', '=', '4')
                ->whereMonth('created_at', $get_month)
                ->where('packaging_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'packaging_lots.created_at AS created_at',
                    'receive_packagings.paper_no AS paper_no',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->join('requsition_packagings', 'requsition_packagings.id', '=', 'packaging_cut_returns.requsition_packaging_id')
                ->whereMonth('packaging_cut_returns.created_at', $get_month)
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    'packaging_cut_returns.action AS type',
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                    'packaging_cut_returns.created_at AS created_at',
                    'requsition_packagings.paper_no AS paper_no',
                );
            }
        }else{
            if($get_month == 13){
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->where('action', '=', '4')
                ->whereYear('created_at', $param['year_search'])
                ->where('packaging_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'packaging_lots.created_at AS created_at',
                    'receive_packagings.paper_no AS paper_no',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->join('requsition_packagings', 'requsition_packagings.id', '=', 'packaging_cut_returns.requsition_packaging_id')
                ->whereYear('packaging_cut_returns.created_at', $param['year_search'])
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    'packaging_cut_returns.action AS type',
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                    'packaging_cut_returns.created_at AS created_at',
                    'requsition_packagings.paper_no AS paper_no',
                );
            }else{
                $get_lot = PackagingLot::where('packaging_id',$param['mat_search'])
                ->join('receive_packagings', 'receive_packagings.id', '=', 'packaging_lots.receive_packaging_id')
                ->where('action', '=', '4')
                ->whereYear('created_at', $param['year_search'])
                ->whereMonth('created_at', $get_month)
                ->where('packaging_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'packaging_lots.created_at AS created_at',
                    'receive_packagings.paper_no AS paper_no',
                );

                $get_cut = PackagingCutReturn::whereIn('packaging_lot_id',$id_lot)
                ->join('packaging_lots', 'packaging_lots.id', '=', 'packaging_cut_returns.packaging_lot_id')
                ->join('requsition_packagings', 'requsition_packagings.id', '=', 'packaging_cut_returns.requsition_packaging_id')
                ->whereYear('packaging_cut_returns.created_at', $param['year_search'])
                ->whereMonth('packaging_cut_returns.created_at', $get_month)
                ->where('packaging_cut_returns.qty', '>', '0')
                ->select(
                    'packaging_cut_returns.action AS type',
                    'packaging_cut_returns.qty AS weight',
                    'packaging_lots.lot AS lot',
                    'packaging_lots.mfg AS mfg',
                    'packaging_lots.exp AS exp',
                    'packaging_cut_returns.created_at AS created_at',
                    'requsition_packagings.paper_no AS paper_no',
                );
            }
        }

        $data = $get_lot->union($get_cut)->orderBy($param['columnName'], $param['columnSortOrder'])->get();

        return $data;
    }

    public function chartImpl()
    {
        $get_all = $this->model->all()->where('record_status','=','1')->where('company_id','=',session('company'));

        $color = ['#0087ff', '#5fb4ff', '#2ec100', '#69b750', '#ede800', '#e5e265','#e30202', '#df5252', '#f15f00', '#e5894e', '#c500d7', '#c64fd1'];

        $lable =[];
        $value =[];
        $data_table = [];
        // $backgroundColor =[];

        foreach ($get_all as $packging_one) {
            $mName = $packging_one->name;
            $mVol = $packging_one->volumetric_unit;
            $sql = DB::table('packaging_lots')
            ->selectRaw('getBalancePackagingStockByPackagingID('.$packging_one->id.') as remain')
            ->first();
            $mLotRemain =$sql->remain;

            // $mLotRemain = PackagingLot::where('packaging_id',$packging_one->id)->join('packagings', 'packaging_lots.packaging_id', '=', 'packagings.id')->orderBy('packagings.name')->sum('qty');

            $lable[] = $mName;
            $value[] = $mLotRemain;
            $data_table[] = [
                'name' => $mName,
                'vol' => $mVol,
                'remain' => $mLotRemain
            ];

        }

        $data = [
            'lable' => $lable,
            'data' => $value,
            'backgroundColor' => $color,
            'aaData' => $data_table,
        ];

        return response()->json($data);
    }

    public function count(): int
    {
        return DB::table('packagings')
        ->select(DB::raw('count(*) as packaging_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('record_status','=',1)
            ->where('company_id','=',$param['company_id'])
            ->where(function($q) use ($param) {
                $q->where('name', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllPackages($name): Collection
    {
        $packagings = DB::table('packagings')
            ->select('*')
            ->where('name', 'like', '%' .$name . '%')
            ->where('record_status','=',1)
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $packagings;
    }

    public function getPackagingLotDetailByID($id): Collection
    {
        $packagings = DB::table('packaging_lots')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        return $packagings;
    }

    public  function getAllWithStockRemain(): Collection
    {
        return $this->model->selectRaw(" *, getBalancePackagingStockByPackagingID(packagings.id) as stockremain")->get();
    }


    public function countReceiveReport($param): int
    {
        $get_month = null;

        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
                $get_lot = $this->value_lot->with('packaging','receivePackaging','receivePackaging.brandVendor','receivePackaging.logisticVendor','receivePackaging.auditUser.employee','receivePackaging.stockUser.employee')
                ->whereYear('packaging_lots.created_at', $param['year_search'])
                ->whereMonth('packaging_lots.created_at', $get_month)
                ->select('*');

        }
        else{
                $get_lot = $this->value_lot->with('packaging','receivePackaging','receivePackaging.brandVendor','receivePackaging.logisticVendor','receivePackaging.auditUser.employee','receivePackaging.stockUser.employee')
                ->whereYear('packaging_lots.created_at', $param['year_search'])
                ->select('*');
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateReceiveReport($param): Collection
    {
        $get_month = null;
        $get_item = null;
        // dd($param);
        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
            if($param['item_search']!='-1'){
                $get_item = $param['item_search'];
                $get_lot = $this->value_lot->with('packaging','receivePackaging','receivePackaging.brandVendor','receivePackaging.logisticVendor','receivePackaging.auditUser.employee','receivePackaging.stockUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('packaging_lots.receive_packaging_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('packaging_lots.created_at', $get_month)
                ->where('packaging_lots.packaging_id','=',$get_item)
                ->select('*');
            }else{
                $get_lot = $this->value_lot->with('packaging','receivePackaging','receivePackaging.brandVendor','receivePackaging.logisticVendor','receivePackaging.auditUser.employee','receivePackaging.stockUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('packaging_lots.receive_packaging_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('packaging_lots.created_at', $get_month)
                ->where('packaging_lots.company_id','=',$param['company_id'])
                ->select('*');
            }
        }
        else{
            if($param['item_search']!='-1'){
                $get_lot = $this->value_lot->with('packaging','receivePackaging','receivePackaging.brandVendor','receivePackaging.logisticVendor','receivePackaging.auditUser.employee','receivePackaging.stockUser.employee');
                $get_item = $param['item_search'];
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('packaging_lots.receive_packaging_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_lots.created_at', $param['year_search']);
                };

                $get_lot = $get_lot
                ->where('packaging_id','=',$get_item)
                ->select('*');
            }else{
                $get_lot = $this->value_lot->with('packaging','receivePackaging','receivePackaging.brandVendor','receivePackaging.logisticVendor','receivePackaging.auditUser.employee','receivePackaging.stockUser.employee');

                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('packaging_lots.receive_packaging_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_lots.created_at', $param['year_search']);
                };

                $get_lot = $get_lot
                ->where('packaging_lots.company_id','=',$param['company_id'])
                ->select('*');
            }
        }

        if (array_key_exists("columnSortOrder", $param)) {
            $data = $get_lot->orderBy($param['columnName'], $param['columnSortOrder'])->get();
        }else{
            $data = $get_lot->get();
        }
        return $data;
    }

    public function countRequsitionReport($param): int
    {
        $get_month = null;

        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee')
                ->whereYear('packaging_cut_returns.created_at', $param['year_search'])
                ->whereMonth('packaging_cut_returns.created_at', $get_month)
                ->select('*');

        }
        else{
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee')
                ->whereYear('packaging_cut_returns.created_at', $param['year_search'])
                ->select('*');
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateRequsitionReport($param): Collection
    {
        $get_month = null;
        $get_item = null;
        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
            if($param['item_search']!='-1'){
                $get_item = $param['item_search'];
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('packaging_cut_returns.requsition_packaging_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot->whereMonth('packaging_cut_returns.created_at', $get_month)
                ->whereHas('packagingLot', function($q) use($param){
                    $q->where('packaging_id', '=', $param['item_search']);
                })
                ->select('*');
            }else{
                $get_item = $param['item_search'];
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('packaging_cut_returns.requsition_packaging_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot->whereMonth('packaging_cut_returns.created_at', $get_month)
                ->whereHas('packagingLot', function($q) use($param){
                    $q->where('company_id', '=', $param['company_id']);
                })
                ->select('*');
            }
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee')
                ->whereYear('packaging_cut_returns.created_at', $param['year_search'])
                ->whereMonth('packaging_cut_returns.created_at', $get_month)
                ->select('*');
        }
        else{
            if($param['item_search']!='-1'){
                $get_item = $param['item_search'];
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('packaging_cut_returns.requsition_packaging_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot
                ->whereHas('packagingLot', function($q) use($param){
                    $q->where('packaging_id', '=', $param['item_search']);
                })
                ->select('*');
            }else{
                $get_item = $param['item_search'];
                $get_lot = $this->value_cut->with('packagingLot.packaging','requsitionPackaging.productionUser.employee','requsitionPackaging.procurementUser.employee','requsitionPackaging.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('packaging_cut_returns.requsition_packaging_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('packaging_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot
                ->whereHas('packagingLot', function($q) use($param){
                    $q->where('company_id', '=', $param['company_id']);
                })
                ->select('*');
            }
        }

        if (array_key_exists("columnSortOrder", $param)) {
            $data = $get_lot->orderBy($param['columnName'], $param['columnSortOrder'])->get();
        }else{
            $data = $get_lot->get();
        }
        return $data;
    }

    public function all() : Collection
    {
        return $this->model->where('record_status',1)->get();
    }

}
