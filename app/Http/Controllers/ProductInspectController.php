<?php

namespace App\Http\Controllers;

use App\Models\HistoryProductInspect;
use App\Models\HistoryProductInspectDetail;
use App\Models\ProductInspect;
use App\Models\ProductInspectDetail;
use App\Repositories\ProductInspectDetailInterface;
use App\Repositories\ProductInspectInterface;
use App\Repositories\ProductLotInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductInspectController extends Controller
{
    private $productLotRepository;
    private $productInspectRepository;
    private $productInspectDetailRepository;

    public function __construct( ProductInspectInterface $productInspectRepository, ProductInspectDetailInterface $productInspectDetailRepository, ProductLotInterface $productLotRepository)
    {
        $this->productLotRepository = $productLotRepository;
        $this->productInspectRepository = $productInspectRepository;
        $this->productInspectDetailRepository = $productInspectDetailRepository;
    }

    public function saveData(Request $request)
    {
        $data = $request->all();
        $statusEdit = $data['statusEdit'];
        $product_lot_id = $data['id'];
        $template_name = $data['selected_name'];
        $topics = $data['topic'];
        $times_results = $data['times_result'];
        $template_id = $data['inspect_template_id'];
        $qauntities = $topics['1']['qty']; //array
        // dd($data);
        $sequence = 0;
        $times = 0;
            $action = [
                'action' => 3,
                'quality_check' => 1,
            ];

        // $user_id = Auth::user()->id;
        if($statusEdit == "1"){
            $getData = $this->productInspectRepository->getInspectDetailByProductLotID($product_lot_id);
            // dd($getData);

            foreach ($getData as $detail) {
                // dd($detail);
                $create_history_product_inspect = HistoryProductInspect::create([
                    'ins_template_name' => $detail->ins_template_name,
                    'ins_topic' => $detail->ins_topic,
                    'ins_method' => $detail->ins_method,
                    'sequence' => $detail->sequence,
                    'product_inspect_id' => $detail->id,
                    'ins_type' => $detail->ins_type,
                    'product_lot_id' => $detail->product_lot_id,
                    'inspect_template_id' => $detail->inspect_template_id,
                    'created_at' => $detail->created_at,
                ]);
                foreach ($detail->productInspectDetails as $detail2){
                    HistoryProductInspectDetail::create([
                        'ins_times' => $detail2->ins_times,
                        'ins_qty' => $detail2->ins_qty,
                        'detail' => $detail2->detail,
                        'history_product_inspect_id' => $create_history_product_inspect->id,
                        'product_lot_id' => $detail2->product_lot_id,
                        'product_inspect_id' => $detail2->product_inspect_id,
                        'audit_user_id' => $detail2->audit_user_id,
                        'created_at' => $detail->created_at,
                ]);
                }
            }
            $delete_inspect =  DB::table('product_inspects')->where('product_lot_id', '=', $product_lot_id)->delete();
            $delete_inspect_detail =  DB::table('product_inspect_details')->where('product_lot_id', '=', $product_lot_id)->delete();
        }
        foreach ($topics as $topic) {
            $create_product_inspect = ProductInspect::create([
                'ins_template_name' => $template_name,
                'ins_topic' => $topic['topic'],
                'ins_method' => $topic['method'],
                'ins_type' => '1',
                'sequence' => ++$sequence,
                'inspect_template_id' => $template_id,
                'product_lot_id' => $product_lot_id,
            ]);
            // dd($qauntities);
            $times=0;
            foreach ($topic['detail'] as $key=>$detail){
                ProductInspectDetail::create([
                    'ins_times' => ++$times,
                    'ins_qty' => $qauntities[$key],
                    'detail' => $detail,
                    'product_lot_id' => $product_lot_id,
                    'product_inspect_id' => $create_product_inspect->id,
                    'audit_user_id' => auth()->user()->id,
                ]);
            }
        }

        foreach ($times_results as $times_result) {
            $create_product_inspect_result = ProductInspect::create([
                'ins_template_name' => $template_name,
                'ins_topic' => 'ผลการประเมิน',
                'ins_method' => 'ผลการประเมิน',
                'ins_type' => '2',
                'sequence' => ++$sequence,
                'product_lot_id' => $product_lot_id,
                'inspect_template_id' => $template_id,
            ]);
            $times=0;
            foreach ($times_result['detail'] as $key=>$detail){
                ProductInspectDetail::create([
                    'ins_times' => ++$times,
                    'ins_qty' => $qauntities[$key],
                    'detail' => $detail,
                    'product_lot_id' => $product_lot_id,
                    'product_inspect_id' => $create_product_inspect_result->id,
                    'audit_user_id' => auth()->user()->id,
                ]);
            }
        }

        $update_product_action = $this->productLotRepository->update($product_lot_id,$action);

        return redirect()->route('check.import.product.stock');
    }
}
