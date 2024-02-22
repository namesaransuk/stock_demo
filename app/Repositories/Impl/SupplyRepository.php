<?php


namespace App\Repositories\Impl;

use App\Models\Supply;
use App\Models\SupplyCut;
use App\Models\SupplyLot;
use App\Repositories\SupplyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SupplyRepository extends BaseRepository implements SupplyInterface
{

    protected $model;
    private $value_lot;
    private $value_cut;

    public function __construct(Supply $model, SupplyLot $value_lot, SupplyCut $value_cut)
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
        $get_id_lot = SupplyLot::where('supply_id',$param['mat_search'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if($param['year_search'] == -1){
            if($get_month == 13){
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->where('action', '=', '2')
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'requsition_supplies.paper_no',
                );
            }else{
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->whereMonth('created_at', $get_month)
                ->where('action', '=', '2')
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->whereMonth('supply_lots.created_at', $get_month)
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'requsition_supplies.paper_no',
                );
            }
        }else{
            if($get_month == 13){
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->where('action', '=', '2')
                ->whereYear('created_at', $param['year_search'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->whereYear('supply_lots.created_at', $param['year_search'])
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'requsition_supplies.paper_no',
                );
            }else{
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->whereYear('created_at', $param['year_search'])
                ->where('action', '=', '2')
                ->whereMonth('created_at', $get_month)
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->whereYear('supply_lots.created_at', $param['year_search'])
                ->whereMonth('supply_lots.created_at', $get_month)
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'requsition_supplies.paper_no',
                );
            }
        }

        $data = $get_lot->union($get_cut)->count();

        return $data;
    }
    public function paginateInventory($param): Collection
    {
        // dd($param);
        $get_month = (array_search($param['month_search'],monthAll())) + 1;

        $id_lot = [];
        $get_id_lot = SupplyLot::where('supply_id',$param['mat_search'])
        ->where('supply_lots.company_id',$param['company_id'])
        ->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if($param['year_search'] == -1){
            if($get_month == 13){
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->where('action', '=', '2')
                ->where('supply_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'supply_lots.created_at AS created_at',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'supply_cuts.created_at AS created_at',
                    'requsition_supplies.paper_no',
                );
            }else{
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->whereMonth('created_at', $get_month)
                ->where('action', '=', '2')
                ->where('supply_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'supply_lots.created_at AS created_at',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->whereMonth('supply_cuts.created_at', $get_month)
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'supply_cuts.created_at AS created_at',
                    'requsition_supplies.paper_no',
                );
            }
        }else{
            if($get_month == 13){
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->whereYear('created_at', $param['year_search'])
                ->where('action', '=', '2')
                ->where('supply_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'supply_lots.created_at AS created_at',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->whereYear('supply_cuts.created_at', $param['year_search'])
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'supply_cuts.created_at AS created_at',
                    'requsition_supplies.paper_no',
                );
            }else{
                $get_lot = SupplyLot::where('supply_id',$param['mat_search'])
                ->join('receive_supplies', 'receive_supplies.id', '=', 'supply_lots.receive_supply_id')
                ->whereYear('created_at', $param['year_search'])
                ->whereMonth('created_at', $get_month)
                ->where('action', '=', '2')
                ->where('supply_lots.company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'supply_lots.created_at AS created_at',
                    'receive_supplies.paper_no',
                );

                $get_cut = SupplyCut::whereIn('supply_lot_id',$id_lot)
                ->join('supply_lots', 'supply_lots.id', '=', 'supply_cuts.supply_lot_id')
                ->join('requsition_supplies', 'requsition_supplies.id', '=', 'supply_cuts.requsition_supply_id')
                ->whereYear('supply_cuts.created_at', $param['year_search'])
                ->whereMonth('supply_cuts.created_at', $get_month)
                ->where('supply_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'supply_cuts.qty AS weight',
                    'supply_lots.lot AS lot',
                    'supply_lots.mfg AS mfg',
                    'supply_lots.exp AS exp',
                    'supply_cuts.created_at AS created_at',
                    'requsition_supplies.paper_no',
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

        foreach ($get_all as $supply_one) {

            $mName = $supply_one->name;
            $sql = DB::table('supply_lots')
            ->selectRaw('getBalanceSupplyStockBySupplyID('.$supply_one->id.') as remain')
            ->first();
            $mLotRemain =$sql->remain;

            $lable[] = $mName;
            $value[] = $mLotRemain;
            $data_table[] = [
                'name' => $mName,
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
        return DB::table('supplies')
        ->select(DB::raw('count(*) as supplies_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('company_id','=',$param['company_id'])
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('name', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllSupplies($name): Collection
    {
        $supplies = DB::table('supplies')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $supplies;
    }

    public  function getAllWithStockRemain(): Collection
    {
        return $this->model->selectRaw(" *, getBalanceSupplyStockBySupplyID(supplies.id) as stockremain")->get();
    }

    public function dataChart()
    {
        $get_all = $this->model->all()->where('record_status','=','1')->where('company_id','=',session('company'));

        $color = ['#0087ff', '#5fb4ff', '#2ec100', '#69b750', '#ede800', '#e5e265','#e30202', '#df5252', '#f15f00', '#e5894e', '#c500d7', '#c64fd1'];

        $lable =[];
        $value =[];
        $data_table =[];
        // $backgroundColor =[];

        foreach ($get_all as $supplies_one) {

            $mName = $supplies_one->name;
            $sql = DB::table('supply_lots')
            ->selectRaw('getBalanceSupplyStockBySupplyID('.$supplies_one->id.') as remain')
            ->first();
            $mLotRemain =$sql->remain;

            // $mLotRemain = SupplyLot::where('supply_id',$supplies_one->id)->sum('qty');

            $lable[] = $mName;
            $value[] = $mLotRemain;
            $data_table[] = [
                'name' => $mName,
                'remain' => $mLotRemain
            ];

        }

        $data = [
            'lable' => $lable,
            'data' => $value,
            'backgroundColor' => $color,
            'aaData' => $data_table,
        ];

        return $data;
    }

    public function countReceiveReport($param): int
    {
        $get_month = null;

        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
                $get_lot = $this->value_lot->with('supply','receiveSupply','receiveSupply.auditUser.employee','receiveSupply.stockUser.employee','receiveSupply.brandVendor')
                ->whereYear('supply_lots.created_at', $param['year_search'])
                ->whereMonth('supply_lots.created_at', $get_month)
                ->select('*');

        }
        else{
                $get_lot = $this->value_lot->with('supply','receiveSupply','receiveSupply.auditUser.employee','receiveSupply.stockUser.employee','receiveSupply.brandVendor')
                ->whereYear('supply_lots.created_at', $param['year_search'])
                ->select('*');
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateReceiveReport($param): Collection
    {
        $get_month = null;
        $get_item = null;
        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
            if($param['item_search']!='-1'){
                $get_item = $param['item_search'];
                $get_lot = $this->value_lot->with('supply','receiveSupply','receiveSupply.auditUser.employee','receiveSupply.stockUser.employee','receiveSupply.brandVendor');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('supply_lots.receive_supply_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('supply_lots.created_at', $get_month)
                ->where('supply_lots.supply_id','=',$get_item)
                ->select('*');
            }else{
                $get_lot = $this->value_lot->with('supply','receiveSupply','receiveSupply.auditUser.employee','receiveSupply.stockUser.employee','receiveSupply.brandVendor');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('supply_lots.receive_supply_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('supply_lots.created_at', $get_month)
                ->where('supply_lots.company_id','=',$param['company_id'])
                ->select('*');
            }
        }
        else{
            if($param['item_search']!='-1'){
                $get_item = $param['item_search'];
                $get_lot = $this->value_lot->with('supply','receiveSupply','receiveSupply.auditUser.employee','receiveSupply.stockUser.employee','receiveSupply.brandVendor');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('supply_lots.receive_supply_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_lots.created_at', $param['year_search']);
                };

                $get_lot = $get_lot
                ->where('supply_lots.supply_id','=',$get_item)
                ->select('*');
            }else{
                $get_lot = $this->value_lot->with('supply','receiveSupply','receiveSupply.auditUser.employee','receiveSupply.stockUser.employee','receiveSupply.brandVendor');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('supply_lots.receive_supply_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_lots.created_at', $param['year_search']);
                };

                $get_lot = $get_lot
                ->where('supply_lots.company_id','=',$param['company_id'])
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
                $get_lot = $this->value_cut->with('supplyLot.supply','requsitionSupply.stockUser.employee')
                ->whereYear('supply_cuts.created_at', $param['year_search'])
                ->whereMonth('supply_cuts.created_at', $get_month)
                ->select('*');

        }
        else{
                $get_lot = $this->value_cut->with('supplyLot.supply','requsitionSupply.stockUser.employee')
                ->whereYear('supply_cuts.created_at', $param['year_search'])
                ->select('*');
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateRequsitionReport($param): Collection
    {
        $get_month = null;
        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
            if($param['item_search']!='-1'){
                $get_lot = $this->value_cut->with('supplyLot.supply','requsitionSupply.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('supply_cuts.requsition_supply_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_cuts.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('supply_cuts.created_at', $get_month)
                ->whereHas('supplyLot', function($q) use($param){
                    $q->where('supply_id', '=', $param['item_search']);
                })
                ->select('*');
            }else{
                $get_lot = $this->value_cut->with('supplyLot.supply','requsitionSupply.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('supply_cuts.requsition_supply_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_cuts.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('supply_cuts.created_at', $get_month)
                ->whereHas('supplyLot', function($q) use($param){
                    $q->where('company_id', '=', $param['company_id']);
                })
                ->select('*');
            }
        }
        else{
            if($param['item_search']!='-1'){
                $get_lot = $this->value_cut->with('supplyLot.supply','requsitionSupply.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('supply_cuts.requsition_supply_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_cuts.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                ->whereHas('supplyLot', function($q) use($param){
                    $q->where('supply_id', '=', $param['item_search']);
                })
                ->select('*');
            }else{
                $get_lot = $this->value_cut->with('supplyLot.supply','requsitionSupply.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('supply_cuts.requsition_supply_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('supply_cuts.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                ->whereHas('supplyLot', function($q) use($param){
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
