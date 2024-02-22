<?php

namespace App\Http\Controllers;

use App\Repositories\ReceiveSupplyInterface;
use App\Repositories\RequsitionSupplyInterface;
use App\Repositories\SupplyInterface;
use Illuminate\Http\Request;

class RequsitionSupplyController extends Controller
{
    private $supplyRepository;
    private $requsitionSupplyRepository;
    public function __construct(SupplyInterface $supplyRepository,RequsitionSupplyInterface $requsitionSupplyRepository)
    {
        $this->supplyRepository = $supplyRepository;
        $this->requsitionSupplyRepository = $requsitionSupplyRepository;
    }
    public function viewListRequsitionSupply()
    {
        return view('requsition_supply.list_requsition_supply');
    }
    public function viewListPendingRequsitionSupply()
    {
        return view('requsition_supply.list_pending_requsition_supply');
    }
    public function viewListHistoryRequsitionSupply()
    {
        return view('requsition_supply.history_requsition_supply');
    }

    public function viewCreateRequsitionSupply()
    {
        $supplies = $this->supplyRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
        return view('requsition_supply.create_requsition_supply',compact('supplies'));
    }

    public function viewEditRequsitionSupply($id)
    {
        $requsition_supply_id = $id;
        $supplies = $this->supplyRepository->all();
        $requsition_supply = $this->requsitionSupplyRepository->find($id);
        return view('requsition_supply.edit_requsition_supply',compact('requsition_supply_id','supplies','requsition_supply'));
    }

    public function viewHistoryEditRequsitionSupply($id)
    {
        $requsition_supply_id = $id;
        return view('requsition_supply.history_edit_requsition_supply',compact('requsition_supply_id'));
    }



}
