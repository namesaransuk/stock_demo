<?php

namespace App\Http\Controllers;

use App\Repositories\PackagingInterface;
use App\Repositories\RequsitionPackagingInterface;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;

class RequsitionPackagingController extends Controller
{

    private $vendorRepository;
    private $packagingRepository;
    private $requsitionPackagingRepository;

    public function __construct(PackagingInterface $packagingRepository, RequsitionPackagingInterface $requsitionPackagingRepository, VendorInterface $vendorRepository)
    {
        $this->packagingRepository = $packagingRepository;
        $this->requsitionPackagingRepository = $requsitionPackagingRepository;
        $this->vendorRepository = $vendorRepository;
    }
    public function listViewRequsitionPackaging()
    {
        return view('requsition_packaging.list_requsition_packaging');
    }

    public function viewCreateRequsitionPackaging()
    {
        $vendors = $this->vendorRepository->all();
        $packagings = $this->packagingRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
       return view('requsition_packaging.create_requsition_packaging',compact('packagings', 'vendors'));
    }

    public function viewEditRequsitionPackaging($id)
    {
        $requsition_packaging_id = $id;
        $packagings = $this->packagingRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
        $requsition_packaging = $this->requsitionPackagingRepository->find($requsition_packaging_id);
        return view('requsition_packaging.edit_requsition_packaging',compact('requsition_packaging_id','packagings','requsition_packaging'));
    }

    public function viewHistoryRequsitionPackaging($id)
    {
        $requsition_packaging_id = $id;
        $packagings = $this->packagingRepository->all();
        $requsition_packaging = $this->requsitionPackagingRepository->find($requsition_packaging_id);
        return view('requsition_packaging.history_requsition_packaging',compact('requsition_packaging_id','packagings','requsition_packaging'));
    }
    public function viewcheckRequsitionPackaging()
    {
        return view('requsition_packaging.list_inspect_requsition_packaging');
    }

    public function viewclaimRequsitionPackaging()
    {
        return view('requsition_packaging.list_claim_requsition_packaging');
    }

    public function viewReturnRequsitionPackaging()
    {
        return view('requsition_packaging.list_return_requsition_packaging');
    }

    public function viewInspectReturnRequsitionPackaging()
    {
        return view('requsition_packaging.list_inspect_requsition_return_packaging');
    }
    public function viewHistoryMasterRequsitionPackaging()
    {
        return view('requsition_packaging.history_requsition_packaging_cut_return');
    }

    public function viewCreateReturnPackaging($id)
    {
        $requsition_packaging_id = $id;
        $packagings = $this->packagingRepository->all();
        $requsition_packaging = $this->requsitionPackagingRepository->find($requsition_packaging_id);
        return view('requsition_packaging.create_return_packaging',compact('requsition_packaging_id','packagings','requsition_packaging'));
    }

    public function listPendingRequsitionPackaging()
    {
        return view('requsition_packaging.list_pending_requsition_packaging');
    }

    public function listPendingReturnRequsitionPackaging()
    {
        return view('requsition_packaging.list_pending_return_requsition_packaging');
    }


}
