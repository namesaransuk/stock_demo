<?php

namespace App\Http\Controllers;

use App\Models\HistoryPackagingInspect;
use App\Models\HistoryPackagingInspectDetail;
use App\Models\PackagingInspect;
use App\Models\PackagingInspectDetail;
use App\Repositories\Impl\PackagingInspectDetailRepository;
use App\Repositories\PackagingInspectInterface;
use App\Repositories\PackagingLotInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackagingInspectController extends Controller
{
    private $packagingLotRepository;
    private $packagingInspectRepository;
    private $packagingInspectDetailRepository;

    public function __construct( PackagingInspectInterface $packagingInspectRepository, PackagingInspectDetailRepository $packagingInspectDetailRepository, PackagingLotInterface $packagingLotRepository)
    {
        $this->packagingInspectRepository = $packagingInspectRepository;
        $this->packagingInspectDetailRepository = $packagingInspectDetailRepository;
        $this->packagingLotRepository = $packagingLotRepository;
    }

    public function saveData(Request $request)
    {
        $data = $request->all();
        $statusEdit = $data['statusEdit'];
        $packaging_lot_id = $data['id'];
        $template_name = $data['selected_name'];
        $topics = $data['topic'];
        $times_results = $data['times_result'];
        $template_id = $data['inspect_template_id'];
        $qauntities = $topics['1']['qty']; //array
        $sequence = 0;
        $times = 0;
        $action = [
            'action' => 3,
            'quality_check' => 1,
        ];

        if($statusEdit == "1"){
            $getData = $this->packagingInspectRepository->getInspectDetailByPackagingLotID($packaging_lot_id);

            foreach ($getData as $detail) {
                $create_history_inspect = HistoryPackagingInspect::create([
                    'ins_template_name' => $detail->ins_template_name,
                    'ins_topic' => $detail->ins_topic,
                    'ins_method' => $detail->ins_method,
                    'packaging_inspect_id' => $detail->id,
                    'ins_type' => $detail->ins_type,
                    'sequence' => $detail->sequence,
                    'packaging_lot_id' => $detail->packaging_lot_id,
                    'inspect_template_id' => $detail->inspect_template_id,
                    'created_at' => $detail->created_at,
                ]);
                foreach ($detail->packagingInspectDetails as $detail2){
                    HistoryPackagingInspectDetail::create([
                        'ins_times' => $detail2->ins_times,
                        'ins_qty' => $detail2->ins_qty,
                        'detail' => $detail2->detail,
                        'history_packaging_inspect_id' => $create_history_inspect->id,
                        'packaging_lot_id' => $detail2->packaging_lot_id,
                        'packaging_inspect_id' => $detail2->packaging_inspect_id,
                        'audit_user_id' => $detail2->audit_user_id,
                        'created_at' => $detail->created_at,
                ]);
                }
            }
            $delete_inspect =  DB::table('packaging_inspects')->where('packaging_lot_id', '=', $packaging_lot_id)->delete();
            $delete_inspect_detail =  DB::table('packaging_inspect_details')->where('packaging_lot_id', '=', $packaging_lot_id)->delete();
        }
        foreach ($topics as $topic) {
            $create_packaging_inspect = PackagingInspect::create([
                'ins_template_name' => $template_name,
                'ins_topic' => $topic['topic'],
                'ins_method' => $topic['method'],
                'ins_type' => '1',
                'sequence' => ++$sequence,
                'packaging_lot_id' => $packaging_lot_id,
                'inspect_template_id' => $template_id,
            ]);
            // dd($qauntities);
            $times=0;
            foreach ($topic['detail'] as $key=>$detail){
                PackagingInspectDetail::create([
                    'ins_times' => ++$times,
                    'ins_qty' => $qauntities[$key],
                    'detail' => $detail,
                    'packaging_lot_id' => $packaging_lot_id,
                    'packaging_inspect_id' => $create_packaging_inspect->id,
                    'audit_user_id' => auth()->user()->id,
                ]);
            }
        }

        foreach ($times_results as $times_result) {
            $create_packaging_inspect_result = PackagingInspect::create([
                'ins_template_name' => $template_name,
                'ins_topic' => 'ผลการประเมิน',
                'ins_method' => 'ผลการประเมิน',
                'ins_type' => '2',
                'sequence' => ++$sequence,
                'packaging_lot_id' => $packaging_lot_id,
                'inspect_template_id' => $template_id,
            ]);
            $times=0;
            foreach ($times_result['detail'] as $key=>$detail){
                PackagingInspectDetail::create([
                    'ins_times' => ++$times,
                    'ins_qty' => $qauntities[$key],
                    'detail' => $detail,
                    'packaging_lot_id' => $packaging_lot_id,
                    'packaging_inspect_id' => $create_packaging_inspect_result->id,
                    'audit_user_id' => auth()->user()->id,
                ]);
            }
        }

        $update_packaging_action = $this->packagingLotRepository->update($packaging_lot_id,$action);

        return redirect()->route('check.import.packaging.stock');
    }
}
