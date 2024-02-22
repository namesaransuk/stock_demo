<?php

namespace App\Http\Controllers;

use App\Models\MaterialInspect;
use App\Models\MaterialInspectDetail;
use App\Repositories\CompanyInterface;
use App\Repositories\InspectTemplateDetailInterface;
use App\Repositories\InspectTemplateInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\MaterialLotInterface;
use App\Repositories\MaterialUnitInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\UserCompanyInterface;
use App\Repositories\VendorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiveMaterialController extends Controller
{
    private $materialRepository;
    private $materialLotRepository;
    private $materialUnitRepository;
    private $companyRepository;
    private $vendorRepository;
    private $inspectTemplateDetailRepository;
    private $inspectTemplateRepository;
    private $receiveMaterialRepository;
    private $userCompanyRepository;

    public function __construct(MaterialUnitInterface $materialUnitRepository, MaterialInterface $materialRepository, CompanyInterface $companyRepository, VendorInterface $vendorRepository, InspectTemplateDetailInterface $inspectTemplateDetailRepository, ReceiveMaterialInterface $receiveMaterialRepository, MaterialLotInterface $materialLotRepository, InspectTemplateInterface $inspectTemplateRepository, UserCompanyInterface $userCompanyRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->userCompanyRepository = $userCompanyRepository;
        $this->materialRepository = $materialRepository;
        $this->materialLotRepository = $materialLotRepository;
        $this->materialUnitRepository = $materialUnitRepository;
        $this->vendorRepository = $vendorRepository;
        $this->inspectTemplateDetailRepository = $inspectTemplateDetailRepository;
        $this->inspectTemplateRepository = $inspectTemplateRepository;
        $this->receiveMaterialRepository = $receiveMaterialRepository;
    }

    public function printGenLot()
    {
        $paper_status = 2;
        $inspect_ready = 1;

        $materials = $this->receiveMaterialRepository->printMaterials(session('company'), $paper_status, $inspect_ready);
        return view('receive_material.print_list_material_lot', compact('materials'));
    }

    public function print()
    {
        $paper_status = 1;
        $inspect_ready = 0;

        $materials = $this->receiveMaterialRepository->printMaterials(session('company'), $paper_status, $inspect_ready);
        return view('receive_material.print_list_receive_material', compact('materials'));
    }

    public function viewStock()
    {
        $materials = $this->materialRepository->all();
        $companies = $this->companyRepository->all();
        $vendors = $this->vendorRepository->all();
        return view('receive_material.list_receive_material', compact('materials', 'companies', 'vendors'));
    }

    public function checkImportStock()
    {
        return view('receive_material.list_inspect_receive_material');
    }

    public function viewCreateReceiveMaterial()
    {
        // getAllCompanyByUserID
        $materialUnit = $this->materialUnitRepository->all();
        $materials = $this->materialRepository->all()->where('company_id', '=', session('company'))->sortBy('name');
        $companies = $this->userCompanyRepository->getAllCompanyByUserID(auth()->user()->id);
        // $mat_lot_detail = $this->materialLotRepository->find($material_lot_id);
        // $companies = $this->companyRepository->all();
        $vendors = $this->vendorRepository->all()->sortBy('brand');
        // dd($vendors);
        return view('receive_material.create_receive_material', compact('materials', 'materialUnit', 'companies', 'vendors'));
    }
    public function viewEditReceiveMaterial($id)
    {
        $material_lot_id = $id;
        $materialUnit = $this->materialUnitRepository->all();
        $receivematerial = $this->receiveMaterialRepository->find($material_lot_id);
        $materials = $this->materialRepository->all()->where('company_id', '=', session('company'))->sortBy('name');
        $companies = $this->userCompanyRepository->getAllCompanyByUserID(auth()->user()->id);
        $vendors = $this->vendorRepository->all()->sortBy('brand');
        return view('receive_material.edit_receive_material', compact('materials', 'companies', 'vendors', 'material_lot_id', 'receivematerial', 'materialUnit'));
    }

    public function viewHistoryEditReceiveMaterial($id)
    {
        $receive_material_id = $id;
        $receivematerial = $this->receiveMaterialRepository->find($receive_material_id);
        $vendors = $this->vendorRepository->all();
        return view('receive_material.history_receive_material', compact('receive_material_id', 'receivematerial', 'vendors'));
    }

    public function viewCheckMaterial($id)
    {
        $material_lot_id = $id;
        $mat_lot_detail = $this->materialLotRepository->find($material_lot_id);
        $mat_detail = $this->materialRepository->find($mat_lot_detail->material_id);
        $receive_detail = $this->receiveMaterialRepository->find($mat_lot_detail->receive_material_id);
        $brand_vendor_name = $this->vendorRepository->find($receive_detail->brand_vendor_id);
        $logistic_vendor_name = $this->vendorRepository->find($receive_detail->logistic_vendor_id);
        $inspect_templates = $this->inspectTemplateRepository->all();
        return view('receive_material.inspect_material', compact('material_lot_id', 'mat_lot_detail', 'mat_detail', 'receive_detail', 'brand_vendor_name', 'logistic_vendor_name', 'inspect_templates'));
    }

    public function viewCheckVehicle($id)
    {
        $material_lot_id = $id;
        $mat_lot_detail = $this->materialLotRepository->find($material_lot_id);
        $mat_detail = $this->materialRepository->find($mat_lot_detail->material_id);
        // dd($mat_detail);
        return view('receive_material.inspect_vehicle', compact('material_lot_id', 'mat_lot_detail', 'mat_detail'));
    }



    public function viewLotNoPMReceiveMaterial()
    {
        $mat_details = $this->materialRepository->all()->where('company_id', '=', session('company'))->sortBy("name");
        return view('receive_material.list_lot_no_pm_receive_material', compact('mat_details'));
    }

    public function viewHistoryInspectReceiveMaterial($id)
    {
        $receive_material_id = $id;
        return view('receive_material.history_inspect_material', compact('receive_material_id'));
    }

    public function viewMasterReceiveMaterial()
    {
        return view('receive_material.master_receive_material');
    }

    public function viewSendtoReceiveMaterial()
    {
        return view('receive_material.list_pending_receive_material');
    }
}
