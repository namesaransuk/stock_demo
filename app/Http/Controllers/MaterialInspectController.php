<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\HistoryMaterialInspect;
use App\Models\HistoryMaterialInspectDetail;
use App\Models\MaterialInspect;
use App\Models\MaterialInspectDetail;
use App\Repositories\MaterialInspectDetailInterface;
use App\Repositories\MaterialInspectInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\ReceiveMaterialInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialInspectController extends Controller
{
    private $receiveMaterialRepository;
    private $materialLotRepository;
    private $materialInspectRepository;
    private $materialInspectDetailRepository;

    public function __construct( MaterialInspectInterface $materialInspectRepository, MaterialInspectDetailInterface $materialInspectDetailRepository, MaterialLotInterface $materialLotRepository, ReceiveMaterialInterface $receiveMaterialRepository)
    {
        $this->receiveMaterialRepository = $receiveMaterialRepository;
        $this->materialLotRepository = $materialLotRepository;
        $this->materialInspectRepository = $materialInspectRepository;
        $this->materialInspectDetailRepository = $materialInspectDetailRepository;
    }

    public function saveData(Request $request)
    {
        $data = $request->all();
        $statusEdit = $data['statusEdit'];
        $material_lot_id = $data['id'];
        $template_name = $data['selected_name'];
        $topics = $data['topic'];
        $times_results = $data['times_result'];
        $results = $data['times_result'];
        $template_id = $data['inspect_template_id'];
        $qauntities = $topics['1']['qty']; //array
        $status = $data['status'];
        // dd($data);
        $sequence = 0;
        $times = 0;
        $status_detail = [
            'quality_check' => 1,
            'action' => 3,
        ];


        //copy old data to history table
        if($statusEdit == "1"){
            $getData = $this->materialInspectRepository->getInspectDetailByMaterialLotID($material_lot_id);

            foreach ($getData as $detail) {
                $create_history_material_inspect = HistoryMaterialInspect::create([
                    'ins_template_name' => $detail->ins_template_name,
                    'ins_topic' => $detail->ins_topic,
                    'ins_method' => $detail->ins_method,
                    'material_inspect_id' => $detail->id,
                    'ins_type' => $detail->ins_type,
                    'sequence' => $detail->sequence,
                    'material_lot_id' => $detail->material_lot_id,
                    'inspect_template_id' => $detail->inspect_template_id,
                    'created_at' => $detail->created_at,
                ]);
                foreach ($detail->materialInspectDetails as $detail2){
                    HistoryMaterialInspectDetail::create([
                        'ins_times' => $detail2->ins_times,
                        'ins_qty' => $detail2->ins_qty,
                        'detail' => $detail2->detail,
                        'history_material_inspect_id' => $create_history_material_inspect->id,
                        'material_lot_id' => $detail2->material_lot_id,
                        'material_inspect_id' => $detail2->material_inspect_id,
                        'audit_user_id' => $detail2->audit_user_id,
                        'created_at' => $detail->created_at,
                ]);
                }
            }
            $delete_inspect =  DB::table('material_inspects')->where('material_lot_id', '=', $material_lot_id)->delete();
            $delete_inspect_detail =  DB::table('material_inspect_details')->where('material_lot_id', '=', $material_lot_id)->delete();
        }
        foreach ($topics as $topic) {
            $create_material_inspect = MaterialInspect::create([
                'ins_template_name' => $template_name,
                'ins_topic' => $topic['topic'],
                'ins_method' => $topic['method'],
                'ins_type' => '1',
                'sequence' => ++$sequence,
                'material_lot_id' => $material_lot_id,
                'inspect_template_id' => $template_id,
            ]);
            // dd($qauntities);
            $times=0;
            foreach ($topic['detail'] as $key=>$detail){
                MaterialInspectDetail::create([
                    'ins_times' => ++$times,
                    'ins_qty' => $qauntities[$key],
                    'detail' => $detail,
                    'material_lot_id' => $material_lot_id,
                    'material_inspect_id' => $create_material_inspect->id,
                    'audit_user_id' => auth()->user()->id,
                ]);
            }
        }

        foreach ($times_results as $times_result) {
            $create_material_inspect_result = MaterialInspect::create([
                'ins_template_name' => $template_name,
                'ins_topic' => 'ผลการประเมิน',
                'ins_method' => 'ผลการประเมิน',
                'ins_type' => '2',
                'sequence' => ++$sequence,
                'material_lot_id' => $material_lot_id,
                'inspect_template_id' => $template_id,
            ]);
            $times=0;
            foreach ($times_result['detail'] as $key=>$detail){
                MaterialInspectDetail::create([
                    'ins_times' => ++$times,
                    'ins_qty' => $qauntities[$key],
                    'detail' => $detail,
                    'material_lot_id' => $material_lot_id,
                    'material_inspect_id' => $create_material_inspect_result->id,
                    'audit_user_id' => auth()->user()->id,
                ]);
            }
        }

        $update_material_action = $this->materialLotRepository->update($material_lot_id,$status_detail);

        return redirect()->route('check.import.material.stock');
    }
}
