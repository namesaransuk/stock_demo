<?php


namespace App\Repositories\Impl;

use App\Models\Material;
use App\Models\MaterialCutReturn;
use App\Models\MaterialLot;
use App\Models\MaterialType;
use App\Models\SupplyLot;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialTypeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MaterialRepository extends BaseRepository implements MaterialInterface
{

    protected $model;
    private $mat_lot;
    private $mat_cut;

    public function __construct(Material $model, MaterialLot $mat_lot, MaterialCutReturn $mat_cut)
    {
        parent::__construct($model);
        $this->mat_lot = $mat_lot;
        $this->mat_cut = $mat_cut;
    }

    public function tradeNameAndRemain($trade_name): Collection
    {
        $materials = $this->model->whereIn('trade_name', $trade_name)
            ->get(array('id', 'name', 'trade_name'));
        return $materials;
    }

    public function getAll()
    {
        return $this->model
            ->where('record_status', '=', '1')
            ->get();
    }

    public function getAllMaterial()
    {
        $materials = $this->model->with('category', 'brandVendor')
            ->where('record_status', '=', 1)
            ->get();
        return $materials;
    }

    public function countInventory($param): int
    {
        $get_month = (array_search($param['month_search'], monthAll())) + 1;
        $id_lot = [];
        $get_id_lot = MaterialLot::where('material_id', $param['mat_search'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if ($param['year_search'] == -1) {
            if ($get_month == 13) {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->where('action', '=', '4')
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        DB::raw('"cut" AS type
                    '),
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                    );
            } else {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->whereMonth('created_at', $get_month)
                    ->where('action', '=', '4')
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->whereMonth('material_lots.created_at', $get_month)
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        DB::raw('"cut" AS type
                    '),
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                    );
            }
        } else {
            if ($get_month == 13) {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->whereYear('created_at', $param['year_search'])
                    ->where('action', '=', '4')
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->whereYear('material_lots.created_at', $param['year_search'])
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        DB::raw('"cut" AS type
                    '),
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                    );
            } else {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->whereYear('created_at', $param['year_search'])
                    ->whereMonth('created_at', $get_month)
                    ->where('action', '=', '4')
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->whereYear('material_lots.created_at', $param['year_search'])
                    ->whereMonth('material_lots.created_at', $get_month)
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        DB::raw('"cut" AS type
                    '),
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                    );
            }
        }

        $data = $get_lot->union($get_cut)->count();

        return $data;
    }
    public function paginateInventory($param): Collection
    {

        $get_month = (array_search($param['month_search'], monthAll())) + 1;

        $id_lot = [];
        $get_id_lot = MaterialLot::where('material_id', $param['mat_search'])->where('material_lots.company_id', $param['company_id'])->get();
        foreach ($get_id_lot as $get_id_lot) {
            $id_lot[] = $get_id_lot->id;
        };

        if ($param['year_search'] == -1) {
            if ($get_month == 13) {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->where('material_lots.company_id', $param['company_id'])
                    ->where('action', '=', '4')

                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                        'material_lots.created_at AS created_at',
                        'receive_materials.paper_no AS paper_no',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        'material_cut_returns.action AS type',
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                        'material_cut_returns.created_at AS created_at',
                        'requsition_materials.paper_no AS paper_no',
                    );
            } else {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->whereMonth('created_at', $get_month)
                    ->where('action', '=', '4')
                    ->where('material_lots.company_id', $param['company_id'])
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                        'material_lots.created_at AS created_at',
                        'receive_materials.paper_no AS paper_no',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->whereMonth('material_cut_returns.created_at', $get_month)
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        'material_cut_returns.action AS type',
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                        'material_cut_returns.created_at AS created_at',
                        'requsition_materials.paper_no AS paper_no',
                    );
            }
        } else {
            if ($get_month == 13) {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->whereYear('created_at', $param['year_search'])
                    ->where('action', '=', '4')
                    ->where('material_lots.company_id', $param['company_id'])
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                        'material_lots.created_at AS created_at',
                        'receive_materials.paper_no AS paper_no',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->whereYear('material_cut_returns.created_at', $param['year_search'])
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        'material_cut_returns.action AS type',
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                        'material_cut_returns.created_at AS created_at',
                        'requsition_materials.paper_no AS paper_no',
                    );
            } else {
                $get_lot = MaterialLot::where('material_id', $param['mat_search'])
                    ->join('receive_materials', 'receive_materials.id', '=', 'material_lots.receive_material_id')
                    ->whereYear('created_at', $param['year_search'])
                    ->whereMonth('created_at', $get_month)
                    ->where('action', '=', '4')
                    ->where('material_lots.company_id', $param['company_id'])
                    ->select(
                        DB::raw('"lot" AS type
                    '),
                        'weight_total AS weight',
                        'lot AS lot',
                        'mfg AS mfg',
                        'exp AS exp',
                        'material_lots.created_at AS created_at',
                        'receive_materials.paper_no AS paper_no',
                    );

                $get_cut = MaterialCutReturn::whereIn('material_lot_id', $id_lot)
                    ->join('material_lots', 'material_lots.id', '=', 'material_cut_returns.material_lot_id')
                    ->join('requsition_materials', 'requsition_materials.id', '=', 'material_cut_returns.requsition_material_id')
                    ->whereYear('material_cut_returns.created_at', $param['year_search'])
                    ->whereMonth('material_cut_returns.created_at', $get_month)
                    ->where('material_cut_returns.weight', '>', '0')
                    ->select(
                        'material_cut_returns.action AS type',
                        'material_cut_returns.weight AS weight',
                        'material_lots.lot AS lot',
                        'material_lots.mfg AS mfg',
                        'material_lots.exp AS exp',
                        'material_cut_returns.created_at AS created_at',
                        'requsition_materials.paper_no AS paper_no',
                    );
            }
        }



        $data = $get_lot->union($get_cut)->orderBy($param['columnName'], $param['columnSortOrder'])->get();

        return $data;
    }

    public function countReceiveReport($param): int
    {
        $get_month = null;
        $get_item = null;

        if ($param['month_search'] != '-1') {
            $get_month = (array_search($param['month_search'], monthAll())) + 1;

            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];
                if ($get_item = '1') {
                    $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee')
                        ->whereYear('material_lots.created_at', $param['year_search'])
                        ->whereMonth('material_lots.created_at', $get_month)
                        ->where('material_lots.material_id', '=', $get_item)
                        ->select('*');
                }
            } else {
                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee')
                    ->whereYear('material_lots.created_at', $param['year_search'])
                    ->whereMonth('material_lots.created_at', $get_month)
                    ->where('material_lots.company_id', '=', $param['company_id'])
                    ->select('*');
            }
        } else {

            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];

                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee')
                    ->whereYear('material_lots.created_at', $param['year_search'])
                    ->where('material_lots.material_id', '=', $get_item)
                    ->select('*');
            } else {
                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee')
                    ->whereYear('material_lots.created_at', $param['year_search'])
                    ->where('material_lots.company_id', '=', $param['company_id'])
                    ->select('*');
            }
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateReceiveReport($param): Collection
    {
        $get_month = null;
        $get_item = null;

        if ($param['month_search'] != '-1') {
            $get_month = (array_search($param['month_search'], monthAll())) + 1;

            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];

                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee');

                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('material_lots.receive_material_id', $param['id_receive']);
                }
                //check all year
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('material_lots.created_at', $get_month)
                    ->where('material_lots.material_id', '=', $get_item)
                    ->select('*');
            } else {
                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('material_lots.receive_material_id', $param['id_receive']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot->whereMonth('material_lots.created_at', $get_month)
                    ->where('material_lots.company_id', '=', $param['company_id'])
                    ->select('*');
            }
        } else {

            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];

                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('material_lots.receive_material_id', $param['id_receive']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                    ->where('material_lots.material_id', '=', $get_item)
                    ->select('*');
            } else {
                $get_lot = $this->mat_lot->with('material', 'receiveMaterial', 'receiveMaterial.brandVendor', 'receiveMaterial.logisticVendor', 'receiveMaterial.auditUser.employee', 'receiveMaterial.stockUser.employee');
                //check receive
                if (array_key_exists("id_receive", $param)) {
                    $get_lot = $get_lot->where('material_lots.receive_material_id', $param['id_receive']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_lots.created_at', $param['year_search']);
                };
                $get_lot = $get_lot
                    ->where('material_lots.company_id', '=', $param['company_id'])
                    ->select('*');
            }
        }

        // dd(array_column($param,"columnName"));

        if (array_key_exists("columnSortOrder", $param)) {
            $data = $get_lot->orderBy($param['columnName'], $param['columnSortOrder'])->get();
        } else {
            $data = $get_lot->get();
        }

        return $data;
    }

    public function countRequsitionReport($param): int
    {
        $get_month = null;
        $get_item = null;

        if ($param['month_search'] != '-1') {
            $get_month = (array_search($param['month_search'], monthAll())) + 1;

            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];
                if ($get_item = '1') {
                    $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee')
                        ->whereYear('material_cut_returns.created_at', $param['year_search'])
                        ->whereMonth('material_cut_returns.created_at', $get_month)
                        ->whereRaw('material_cut_returns.material_lot_id IN (SELECT material_lots.id FROM material_lots WHERE id = material_cut_returns.material_lot_id AND material_lots.material_id IN (SELECT materials.id FROM materials WHERE category_id = ?))', [$get_item])
                        ->select('*');
                }
            } else {
                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee')
                    ->whereYear('material_cut_returns.created_at', $param['year_search'])
                    ->whereMonth('material_cut_returns.created_at', $get_month)
                    ->select('*');
            }
        } else {

            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];

                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee')
                    ->whereYear('material_cut_returns.created_at', $param['year_search'])
                    ->whereRaw('material_cut_returns.material_lot_id IN (SELECT material_lots.id FROM material_lots WHERE id = material_cut_returns.material_lot_id AND material_lots.material_id IN (SELECT materials.id FROM materials WHERE category_id = ?))', [$get_item])
                    ->select('*');
            } else {
                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee')
                    ->whereYear('material_cut_returns.created_at', $param['year_search'])
                    ->select('*');
            }
        }

        $data = $get_lot->count();

        return $data;
    }

    public function paginateRequsitionReport($param): Collection
    {
        $get_month = null;
        $get_item = null;

        if ($param['month_search'] != '-1') {
            $get_month = (array_search($param['month_search'], monthAll())) + 1;
            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];
                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('material_cut_returns.requsition_material_id', $param['id_requsition']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot->whereMonth('material_cut_returns.created_at', $get_month)
                    ->whereHas('materialLot', function ($q) use ($param) {
                        $q->where('material_id', '=', $param['item_search']);
                    })
                    ->select('*');
            } else {
                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('material_cut_returns.requsition_material_id', $param['id_requsition']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot->whereMonth('material_cut_returns.created_at', $get_month)
                    ->whereHas('materialLot', function ($q) use ($param) {
                        $q->where('company_id', '=', $param['company_id']);
                    })
                    ->select('*');
            }
        } else {
            if ($param['item_search'] != '-1') {
                $get_item = $param['item_search'];
                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('material_cut_returns.requsition_material_id', $param['id_requsition']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot
                    ->whereHas('materialLot', function ($q) use ($param) {
                        $q->where('material_id', '=', $param['item_search']);
                    })
                    ->select('*');
            } else {
                $get_lot = $this->mat_cut->with('materialLot.material', 'requsitionMaterial.productionUser.employee', 'requsitionMaterial.procurementUser.employee', 'requsitionMaterial.stockUser.employee');
                if (array_key_exists("id_requsition", $param)) {
                    $get_lot = $get_lot->where('material_cut_returns.requsition_material_id', $param['id_requsition']);
                }
                if ($param['year_search'] != '-1') {
                    $get_lot = $get_lot->whereYear('material_cut_returns.created_at', $param['year_search']);
                }
                $get_lot = $get_lot
                    ->whereHas('materialLot', function ($q) use ($param) {
                        $q->where('company_id', '=', $param['company_id']);
                    })
                    ->select('*');
            }
        }
        if (array_key_exists("columnSortOrder", $param)) {
            $data = $get_lot->orderBy($param['columnName'], $param['columnSortOrder'])->get();
        } else {
            $data = $get_lot->get();
        }
        return $data;
    }

    public function materialList()
    {
        $data = $this->model->with('brandVendor')->where('record_status', '=', '1')->where('company_id', '=', session('company'))->get();
        return $data;
    }


    public function chartImpl()
    {
        $get_all = $this->model->with('brandVendor')->where('record_status', '=', '1')->where('company_id', '=', session('company'))->get();

        $color = ['#0087ff', '#5fb4ff', '#2ec100', '#69b750', '#ede800', '#e5e265', '#e30202', '#df5252', '#f15f00', '#e5894e', '#c500d7', '#c64fd1'];

        $lable = [];
        $value = [];
        $data_table = [];
        // $backgroundColor =[];

        foreach ($get_all as $material_one) {
            $mLotRemain = 0;
            $mName = $material_one->name;
            $mBrand = '';
            if ($material_one->brandVendor) {
                $mBrand = $material_one->brandVendor->brand;
            }
            $sql = DB::table('material_lots')
                ->selectRaw('getBalanceMaterialStockByMaterialID(' . $material_one->id . ') as remain')
                ->first();
            $mLotRemain = $sql->remain;

            $lable[] = $mName;
            $value[] = $mLotRemain;
            $data_table[] = [
                'name' => $mName . ' : ' . $mBrand,
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
        return DB::table('materials')
            ->select(DB::raw('count(*) as material_count'))
            ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->with('category', 'brandVendor')->orderBy($param['columnName'], $param['columnSortOrder'])

            // ->where(function ($q) use ($param) {
            //     if ($param['categoryFilter'] > 0) {
            //         $q->where('category_id', '=', $param['categoryFilter']);
            //     }
            // })
            ->where('record_status', '=', 1)
            ->where('materials.company_id', '=', $param['company_id'])
            // ->where('materials.id', '=', $param['searchValue'])
            ->where(function ($q) use ($param) {
                if (isset($param['searchValue'])) {
                    $q->where('materials.id', '=', $param['searchValue']);
                    $q->orWhere('name', 'like', '%' . $param['searchValue'] . '%');
                    $q->orWhere('trade_name', 'like', '%' . $param['searchValue'] . '%');
                    $q->orWhereHas('category', function ($qs) use ($param) {
                        $qs->where('name', 'like', '%' . $param['searchValue'] . '%');
                    });
                    $q->orWhereHas('brandVendor', function ($qs) use ($param) {
                        $qs->where('brand', 'like', '%' . $param['searchValue'] . '%');
                    });
                }

                if (isset($param['categoryFilter']) && $param['categoryFilter'] >= 0) {
                    $q->where('category_id', '=', $param['categoryFilter']);
                }
            })

            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }

    public function getAllMaterials($param): Collection
    {
        $materials = $this->model->with('category', 'brandVendor')->where('record_status', '=', 1)
            ->where('materials.company_id', '=', $param['company_id'])
            ->where(function ($q) use ($param) {
                if (isset($param['searchValue'])) {
                    $q->where('materials.id', '=', $param['searchValue']);
                    $q->where('name', 'like', '%' . $param['searchValue'] . '%');
                    $q->orWhere('trade_name', 'like', '%' . $param['searchValue'] . '%');
                    $q->orWhereHas('category', function ($qs) use ($param) {
                        $qs->where('name', 'like', '%' . $param['searchValue'] . '%');
                    });
                    $q->orWhereHas('brandVendor', function ($qs) use ($param) {
                        $qs->where('brand', 'like', '%' . $param['searchValue'] . '%');
                    });
                }

                if (isset($param['categoryFilter']) && $param['categoryFilter'] >= 0) {
                    $q->where('category_id', '=', $param['categoryFilter']);
                }
            })
            ->select('*')
            ->get();
        return $materials;
    }

    public function getMaterialLotDetailByID($id): Collection
    {
        $materials = DB::table('material_lots')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        return $materials;
    }

    public  function getAllWithStockRemain(): Collection
    {
        return $this->model->selectRaw(" *, getBalanceMaterialStockByMaterialID(materials.id) as stockremain")->get();
    }

    public function all(): Collection
    {
        return $this->model->where('record_status', 1)->get();
    }
}
