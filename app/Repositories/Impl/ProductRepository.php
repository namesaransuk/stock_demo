<?php


namespace App\Repositories\Impl;

use App\Models\Product;
use App\Models\ProductCut;
use App\Models\ProductLot;
use App\Models\ProductType;
use App\Repositories\ProductInterface;
use App\Repositories\ProductTypeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductInterface
{

    protected $model;
    private $value_lot;
    private $value_cut;

    public function __construct(Product $model, ProductLot $value_lot, ProductCut $value_cut)
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
        $get_id_lot = ProductLot::where('product_id',$param['mat_search'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if($param['year_search'] == -1){
            if($get_month == 13){
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                );
            }else{
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->whereMonth('created_at', $get_month)
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->whereMonth('product_lots.created_at', $get_month)
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                );
            }
        }else{
            if($get_month == 13){
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->whereYear('created_at', $param['year_search'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->whereYear('product_lots.created_at', $param['year_search'])
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                );
            }else{
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->whereYear('created_at', $param['year_search'])
                ->whereMonth('created_at', $get_month)
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->whereYear('product_lots.created_at', $param['year_search'])
                ->whereMonth('product_lots.created_at', $get_month)
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
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
        $get_id_lot = ProductLot::where('product_id',$param['mat_search'])->where('company_id',$param['company_id'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };


        if($param['year_search'] == -1){
            if($get_month == 13){
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->where('company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'created_at AS created_at',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                    'product_cuts.created_at AS created_at',
                );
            }else{
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->whereMonth('created_at', $get_month)
                ->where('company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'created_at AS created_at',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->whereMonth('product_cuts.created_at', $get_month)
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                    'product_cuts.created_at AS created_at',
                );
            }
        }else{
            if($get_month == 13){
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->whereYear('created_at', $param['year_search'])
                ->where('company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'created_at AS created_at',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->whereYear('product_cuts.created_at', $param['year_search'])
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                    'product_cuts.created_at AS created_at',
                );
            }else{
                $get_lot = ProductLot::where('product_id',$param['mat_search'])
                ->whereYear('created_at', $param['year_search'])
                ->whereMonth('created_at', $get_month)
                ->where('company_id',$param['company_id'])
                ->select(
                    DB::raw('"lot" AS type
                    '),'qty AS weight',
                    'lot AS lot',
                    'mfg AS mfg',
                    'exp AS exp',
                    'created_at AS created_at',
                );

                $get_cut = ProductCut::whereIn('product_lot_id',$id_lot)
                ->join('product_lots', 'product_lots.id', '=', 'product_cuts.product_lot_id')
                ->whereYear('product_cuts.created_at', $param['year_search'])
                ->whereMonth('product_cuts.created_at', $get_month)
                ->where('product_cuts.qty', '>', '0')
                ->select(
                    DB::raw('"cut" AS type
                    '),
                    'product_cuts.qty AS weight',
                    'product_lots.lot AS lot',
                    'product_lots.mfg AS mfg',
                    'product_lots.exp AS exp',
                    'product_cuts.created_at AS created_at',
                );
            }
        }



        $data = $get_lot->union($get_cut)->orderBy($param['columnName'], $param['columnSortOrder'])->get();
        // dd($data);



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

        foreach ($get_all as $product_one) {

            $mName = $product_one->name;
            $sql = DB::table('supply_lots')
            ->selectRaw('getBalanceProductStockByProductID('.$product_one->id.') as remain')
            ->first();
            $mLotRemain =$sql->remain;

            // $mLotRemain = ProductLot::where('product_id',$product_one->id)->join('products', 'product_lots.packaging_id', '=', 'products.id')->orderBy('products.name')->sum('qty');

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
        return DB::table('products')
        ->select(DB::raw('count(*) as material_count'))
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->with('category')->orderBy($param['columnName'],$param['columnSortOrder'])

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
    public function getAllProducts($name): Collection
    {
        $products = DB::table('products')
            ->select('*')
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $products;
    }
    public function getProductLotDetailByID($id): Collection
    {
        $products = DB::table('product_lots')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        return $products;
    }

    public  function getAllWithStockRemain(): Collection
    {
        return $this->model->selectRaw(" *, getBalanceProductStockByProductID(products.id) as stockremain")->get();
    }


    public function countReceiveReport($param): int
    {
        $get_month = null;

        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
                $get_lot = $this->value_lot->with('product','receiveproduct','receiveproduct.productionUser.employee','receiveproduct.stockUser.employee','receiveproduct.updateUser.employee')
                ->whereYear('product_lots.created_at', $param['year_search'])
                ->whereMonth('product_lots.created_at', $get_month)
                ->select('*');

        }
        else{
                $get_lot = $this->value_lot->with('product','receiveproduct','receiveproduct.productionUser.employee','receiveproduct.stockUser.employee','receiveproduct.updateUser.employee')
                ->whereYear('product_lots.created_at', $param['year_search'])
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
                $get_lot = $this->value_lot->with('product','receiveproduct','receiveproduct.productionUser.employee','receiveproduct.stockUser.employee','receiveproduct.updateUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('product_lots.receive_product_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('product_lots.created_at', $get_month)
                ->where('product_lots.product_id','=',$get_item)
                ->select('*');
            }else{
                $get_lot = $this->value_lot->with('product','receiveproduct','receiveproduct.productionUser.employee','receiveproduct.stockUser.employee','receiveproduct.updateUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('product_lots.receive_product_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('product_lots.created_at', $get_month)
                ->where('product_lots.company_id','=',$param['company_id'])
                ->select('*');
            }
        }
        else{
            if($param['item_search']!='-1'){
                $get_item = $param['item_search'];
                $get_lot = $this->value_lot->with('product','receiveproduct','receiveproduct.productionUser.employee','receiveproduct.stockUser.employee','receiveproduct.updateUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('product_lots.receive_product_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                ->where('product_lots.product_id','=',$get_item)
                ->select('*');
            }else{
                $get_lot = $this->value_lot->with('product','receiveproduct','receiveproduct.productionUser.employee','receiveproduct.stockUser.employee','receiveproduct.updateUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('product_lots.receive_product_id', $param['id_receive']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                ->where('product_lots.company_id','=',$param['company_id'])
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
                $get_lot = $this->value_cut->with('productLot.product','requsitionProduct.stockUser.employee','requsitionProduct.auditUser.employee')
                ->whereYear('product_cuts.created_at', $param['year_search'])
                ->whereMonth('product_cuts.created_at', $get_month)
                ->select('*');

        }
        else{
                $get_lot = $this->value_cut->with('productLot.product','requsitionProduct.stockUser.employee','requsitionProduct.auditUser.employee')
                ->whereYear('product_cuts.created_at', $param['year_search'])
                ->select('*');
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateRequsitionReport($param): Collection
    {
        $get_item = null;
        $get_month = null;
        if($param['month_search']!='-1'){
            $get_month = (array_search($param['month_search'],monthAll())) + 1;
            if($param['item_search']!='-1'){
                $get_lot = $this->value_cut->with('productLot.product','requsitionProduct.stockUser.employee','requsitionProduct.auditUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('product_lots.requsition_product_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('product_cuts.created_at', $get_month)
                ->whereHas('productLot', function($q) use($param){
                    $q->where('product_id', '=', $param['item_search']);
                })
                ->select('*');
            }else{
                $get_lot = $this->value_cut->with('productLot.product','requsitionProduct.stockUser.employee','requsitionProduct.auditUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('product_lots.requsition_product_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('product_cuts.created_at', $get_month)
                ->whereHas('productLot', function($q) use($param){
                    $q->where('company_id', '=', $param['company_id']);
                })
                ->select('*');
            }
        }
        else{
            if($param['item_search']!='-1'){
                $get_lot = $this->value_cut->with('productLot.product','requsitionProduct.stockUser.employee','requsitionProduct.auditUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('product_cuts.requsition_product_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_cuts.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                ->whereHas('productLot', function($q) use($param){
                    $q->where('product_id', '=', $param['item_search']);
                })
                ->select('*');
            }else{
                $get_lot = $this->value_cut->with('productLot.product','requsitionProduct.stockUser.employee','requsitionProduct.auditUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('product_cuts.requsition_product_id', $param['id_requsition']);
                }
                if ($param['year_search']!='-1') {
                    $get_lot = $get_lot->whereYear('product_cuts.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                ->whereHas('productLot', function($q) use($param){
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
