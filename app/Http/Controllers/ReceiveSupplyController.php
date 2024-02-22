<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyInterface;
use App\Repositories\ReceiveSupplyInterface;
use App\Repositories\SupplyInterface;
use App\Repositories\SupplyLotInterface;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;

class ReceiveSupplyController extends Controller
{
    private $companyRepository;
    private $receiveSupplyRepository;
    private $supplyLotRepository;
    private $venderRepository;
    private $supplyRepository;

    public function __construct(CompanyInterface $companyRepository, ReceiveSupplyInterface $receiveSupplyRepository, SupplyLotInterface $supplyLotRepository,SupplyInterface $supplyRepository,VendorInterface $venderRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->receiveSupplyRepository = $receiveSupplyRepository;
        $this->supplyLotRepository = $supplyLotRepository;
        $this->supplyRepository = $supplyRepository;
        $this->venderRepository = $venderRepository;
    }

    public function viewListReceiveSupply()
    {
        return view('receive_supply.list_receive_supply');
    }

    public function viewCreateReceiveSupply()
    {
        $vendors = $this->venderRepository->all()->sortBy('brand');
        $companies = $this->companyRepository->all();
        $supplies = $this->supplyRepository->all()->where('company_id','=',session('company'))->sortBy('name');
        // dd($supplies);
        return view('receive_supply.create_receive_supply',compact('companies','supplies','vendors'));

    }

    public function viewEditReceiveSupply($id)
    {
        $receive_supply_id = $id;
        $receivesupply = $this->receiveSupplyRepository->find($receive_supply_id);
        $vendors = $this->venderRepository->all()->sortBy('brand');
        $companies = $this->companyRepository->all();
        $supplies = $this->supplyRepository->all()->where('company_id','=',session('company'))->sortBy('name');
        return view('receive_supply.edit_receive_supply',compact('receive_supply_id','receivesupply','companies','supplies','vendors'));
    }

    public function viewHistoryEditReceiveSupply($id)
    {
        $receive_supply_id = $id;
        $receivesupply = $this->receiveSupplyRepository->find($receive_supply_id);
        $vendors = $this->venderRepository->all();
        $companies = $this->companyRepository->all();
        $supplies = $this->supplyRepository->all();
        return view('receive_supply.history_edit_receive_supply',compact('receive_supply_id','receivesupply','companies','supplies','vendors'));
    }

    public function viewListPendingReceiveSupply()
    {
        return view('receive_supply.list_pending_receive_supply');
    }

    public function viewListHistoryReceiveSupply()
    {
        return view('receive_supply.list_history_receive_supply');
    }
}
