<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BlItemInterface;
use App\Repositories\TransferInterface;
use App\Repositories\ReceiveInterface;
use App\Repositories\RcdetailInterface;
use Illuminate\Support\Arr;

class TransferController extends Controller
{
    private $blItemRepository;
    private $transferRepository;
    private $receiveRepository;
    private $rcdetailRepository;
    public function __construct(
        BlItemInterface $blItemRepository,
        TransferInterface $transferRepository,
        ReceiveInterface $receiveRepository,
        RcdetailInterface $rcdetailRepository
    ) {
        $this->blItemRepository = $blItemRepository;
        $this->transferRepository = $transferRepository;
        $this->receiveRepository = $receiveRepository;
        $this->rcdetailRepository = $rcdetailRepository;
    }

    public function getOrderTransfer(Request $request)
    {
        $data = $request->all();
        try {
            $transfers = $this->transferRepository->findByMbId($data['memberId']);
            foreach ($transfers as $transfer) {
                $receives = $this->receiveRepository->findByMbId($transfer->orderId);
                foreach ($receives as $receive) {
                    $rcdetails = $this->rcdetailRepository->findByMbId($receive->rcid);
                    $transfer->orderReceive = $receive;
                    foreach ($rcdetails as $rcdetail) {
                        $blitem = $this->blItemRepository->findByMbId($rcdetail->itemid);
                        $transfer->orderDetail = $rcdetails;
                        foreach ($transfer->orderDetail as $orderDetail) {
                            $orderDetail->itemname = $blitem->itemdisplayname;
                        }
                    }
                }
            }
            if (isset($transfers)) {
                $result['orders'] = $transfers;
                $result['txnStatus'] = "OK";
                $result['statusCode'] = "00";
                $result['errorCode'] = null;
                $result['errorDesc'] = null;
            }
        } catch (\Exception $ex) {
            $result['txnStatus'] = "ERROR";
            $result['statusCode'] = "10";
            $result['errorCode'] = "EGO";
            // $result['errorDesc'] = "Error get order";
            $result['errorDesc'] = $ex->getMessage();
        }
        return json_encode($result);
    }

    public function uploadPayment(Request $request)
    {
        $data = $request->all();
        try {
            $transfer = $this->transferRepository->uploadPayment($data);
            if (isset($transfer)) {
                $result['orderId'] = $transfer->tfid;
                $result['memberID'] = $transfer->mbid;
                $result['txnStatus'] = "PAYMENT REGISTERED";
                $result['statusCode'] = "00";
                $result['errorCode'] = null;
                $result['errorDesc'] = null;
            }
        } catch (\Exception $ex) {
            $result['txnStatus'] = "ERROR";
            $result['statusCode'] = "10";
            $result['errorCode'] = "EPR";
            $result['errorDesc'] = "Error payment registered";
            // $result['errorDesc'] = $ex->getMessage();
        }
        return json_encode($result);
    }

    public function uploadPaymentSlip(Request $request)
    {
        $data = $request->all();
        $image = $request->file('orderImage');
        $data['orderImage'] = save_image($image, 2000, public_path('image/'));
        $orderImage = base64_decode($data['orderImage']);
        try {
            $transfer = $this->transferRepository->uploadPaymentSlip($data, $orderImage);
            if (isset($transfer)) {
                $result['orderId'] = $transfer->tfid;
                $result['txnStatus'] = "IMAGE PAYMENT UPLOADED";
                $result['statusCode'] = "00";
                $result['errorCode'] = null;
                $result['errorDesc'] = null;
            }
        } catch (\Exception $ex) {
            $result['txnStatus'] = "ERROR";
            $result['statusCode'] = "10";
            $result['errorCode'] = "EIPR";
            $result['errorDesc'] = "Error image payment uploaded";
            // $result['errorDesc'] = $ex->getMessage();
        }
        return json_encode($result);
    }
}
