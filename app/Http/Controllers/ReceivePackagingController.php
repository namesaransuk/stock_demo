<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyInterface;
use App\Repositories\FdaBrandInterface;
use App\Repositories\InspectTemplateDetailInterface;
use App\Repositories\InspectTemplateInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\PackagingLotInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\UserCompanyInterface;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;

class ReceivePackagingController extends Controller
{
    private $packagingRepository;
    private $packagingLotRepository;
    private $companyRepository;
    private $userCompanyRepository;
    private $vendorRepository;
    private $inspectTemplateDetailRepository;
    private $inspectTemplateRepository;
    private $receivePackagingRepository;
    private $fdaBrandRepository;
    public function __construct(FdaBrandInterface $fdaBrandRepository, PackagingInterface $packagingRepository, CompanyInterface $companyRepository, VendorInterface $vendorRepository, ReceivePackagingInterface $receivePackagingRepository, InspectTemplateDetailInterface $inspectTemplateDetailRepository, InspectTemplateInterface $inspectTemplateRepository, PackagingLotInterface $packagingLotRepository, UserCompanyInterface $userCompanyRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->fdaBrandRepository = $fdaBrandRepository;
        $this->packagingRepository = $packagingRepository;
        $this->packagingLotRepository = $packagingLotRepository;
        $this->vendorRepository = $vendorRepository;
        $this->receivePackagingRepository = $receivePackagingRepository;
        $this->inspectTemplateDetailRepository = $inspectTemplateDetailRepository;
        $this->inspectTemplateRepository = $inspectTemplateRepository;
        $this->userCompanyRepository = $userCompanyRepository;
    }

    public function viewListPackaging()
    {
        return view('receive_packaging.list_receive_packaging');
    }

    public function viewCreate()
    {
        $packagings = $this->packagingRepository->all()->where('record_status', '=', 1)->where('company_id', '=', session('company'))->sortBy('name');
        $companies = $this->userCompanyRepository->getAllCompanyByUserID(auth()->user()->id);
        $vendors = $this->vendorRepository->all()->sortBy('brand');
        $brands = $this->fdaBrandRepository->all()->sortBy('brand');
        return view('receive_packaging.create_receive_packaging', compact('packagings', 'companies', 'vendors', 'brands'));
    }

    public function viewEditReceivePackaging($id)
    {
        $packaging_lot_id = $id;
        $receivepackaging = $this->receivePackagingRepository->find($packaging_lot_id);
        $packagings = $this->packagingRepository->all()->where('company_id', '=', session('company'))->sortBy('name');
        $companies = $this->userCompanyRepository->getAllCompanyByUserID(auth()->user()->id);
        $vendors = $this->vendorRepository->all()->sortBy('brand');
        return view('receive_packaging.edit_receive_packaging', compact('packagings', 'companies', 'vendors', 'packaging_lot_id', 'receivepackaging'));
    }
    public function viewHistoryEditReceivePackaging($id)
    {
        $receive_packaging_id = $id;
        $receivepackaging = $this->receivePackagingRepository->find($receive_packaging_id);
        $packagings = $this->packagingRepository->all();
        $companies = $this->userCompanyRepository->getAllCompanyByUserID(auth()->user()->id);
        $vendors = $this->vendorRepository->all();
        return view('receive_packaging.history_receive_packaging', compact('receive_packaging_id', 'packagings', 'companies', 'vendors', 'receivepackaging'));
    }

    public function viewLotNoPMReceivePackaging()
    {
        return view('receive_packaging.list_lot_no_pm_receive_packaging');
    }

    public function checkReceivePackaging()
    {
        return view('receive_packaging.list_inspect_receive_packaging');
    }

    public function viewCheckPackaging($id)
    {
        $packaging_lot_id = $id;
        $pac_lot_detail = $this->packagingLotRepository->find($packaging_lot_id);
        $pac_detail = $this->packagingRepository->find($pac_lot_detail->packaging_id);
        $receive_detail = $this->receivePackagingRepository->find($pac_lot_detail->receive_packaging_id);
        $brand_vendor_name = $this->vendorRepository->find($receive_detail->brand_vendor_id);
        $logistic_vendor_name = $this->vendorRepository->find($receive_detail->logistic_vendor_id);
        $inspect_templates = $this->inspectTemplateRepository->all();
        // $template_detail = json_decode($template_details);
        // dd( $receive_detail);
        return view('receive_packaging.inspect_packaging', compact('packaging_lot_id', 'pac_lot_detail', 'pac_detail', 'receive_detail', 'brand_vendor_name', 'logistic_vendor_name', 'inspect_templates'));
    }

    public function viewCheckVehicle($id)
    {
        $packaging_lot_id = $id;
        $pac_lot_detail = $this->packagingLotRepository->find($packaging_lot_id);
        $pac_detail = $this->packagingRepository->find($pac_lot_detail->packaging_id);
        // dd($pac_detail);
        return view('receive_packaging.inspect_vehicle', compact('packaging_lot_id', 'pac_lot_detail', 'pac_detail'));
    }

    public function viewPendingReceivePackaging()
    {
        return view('receive_packaging.list_pending_receive_packaging');
    }

    public function viewHistoryReceivePackaging()
    {
        return view('receive_packaging.master_receive_packaging');
    }
}
