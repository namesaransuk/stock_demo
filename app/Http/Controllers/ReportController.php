<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryInterface;
use App\Repositories\CompanyInterface;
use Illuminate\Http\Request;
use App\Repositories\MaterialInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\ProductInterface;
use App\Repositories\ReceiveMaterialInterface;
use App\Repositories\ReceivePackagingInterface;
use App\Repositories\ReceiveProductInterface;
use App\Repositories\ReceiveSupplyInterface;
use App\Repositories\RequsitionMaterialInterface;
use App\Repositories\RequsitionSupplyInterface;
use App\Repositories\RequsitionPackagingInterface;
use App\Repositories\RequsitionProductInterface;
use App\Repositories\SupplyInterface;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function __construct(MaterialInterface $mat_impl,PackagingInterface $packaging_impl,ProductInterface $product_impl,SupplyInterface $supply_impl,CategoryInterface $categories,
        ReceiveMaterialInterface $receiveMaterialRepository,
        ReceivePackagingInterface $receivePackagingimpl,
        ReceiveProductInterface $receiveProductimpl,
        ReceiveSupplyInterface $receiveSupplyimpl,
        RequsitionMaterialInterface $requsitionMaterialimpl,
        RequsitionPackagingInterface $requsitionPackagingimpl,
        RequsitionProductInterface $requsitionProductimpl,
        RequsitionSupplyInterface $requsitionSupplyimpl,
        CompanyInterface $companyRepository
    ) {
        $this->mat_impl = $mat_impl;
        $this->packaging_impl = $packaging_impl;
        $this->product_impl = $product_impl;
        $this->supply_impl = $supply_impl;
        $this->categories = $categories;
        $this->receiveMaterialRepository = $receiveMaterialRepository;
        $this->receivePackagingimpl = $receivePackagingimpl;
        $this->receiveProductimpl = $receiveProductimpl;
        $this->receiveSupplyimpl = $receiveSupplyimpl;
        $this->requsitionMaterialimpl = $requsitionMaterialimpl;
        $this->requsitionPackagingimpl = $requsitionPackagingimpl;
        $this->requsitionProductimpl = $requsitionProductimpl;
        $this->requsitionSupplyimpl = $requsitionSupplyimpl;
        $this->companyRepository = $companyRepository;
        $this->date_now = date_format(Carbon::now(),"Y_m_d_H_i");
    }

    public function reportReceiveMaterialPDF(Request $request)
    {
        $param = [
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];
        $records = $this->mat_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_material',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Material_All_'.$this->date_now.'.pdf');
    }

    public function reportReceiveMaterialPdfOther($id)
    {
        $get_receive = $this->receiveMaterialRepository->find($id);
        $param = [
            "item_search" => -1,
            "month_search" => -1,
            "year_search" => -1,
            "id_receive" => $id,
            "company_id" => session('company'),
        ];
        $records = $this->mat_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_material_other
        ',[
            'data' =>  $records,
            'data_receive' =>  $get_receive,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);
        return $pdf->download('Material_All_'.$this->date_now.'.pdf');
    }

    public function reportReceiveMaterial()
    {
        // dd($this->categories->all());
        return view('admin.report.report_receive_material',[
            'mat' => $this->mat_impl->all()->where('company_id','=',session('company')),
            'cat' => $this->categories->getMatCategories(),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }
    public function reportReceivePackaging()
    {
        return view('admin.report.report_receive_packaging',[
            'pac' => $this->packaging_impl->all()->where('company_id','=',session('company')),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function reportReceivePackagingPDF(Request $request)
    {
        $param = [
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];

        $records = $this->packaging_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_packaging',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Packaging_All_'.$this->date_now.'.pdf');
    }

    public function reportReceivePackagingPdfOther($id)
    {
        $receive_packaging = $this->receivePackagingimpl->find($id);

        $param = [
            "month_search" => '-1',
            "year_search" => '-1',
            "id_receive" => $id,
            "company_id" => session('company'),
        ];

        $records = $this->packaging_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);

        $pdf = PDF::loadView('admin.report.pdf.pdf_all_packaging_other',[
            'data' =>  $records,
            'data_receive' =>  $receive_packaging,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Packaging_All_'.$this->date_now.'.pdf');
    }

    public function reportReceiveProduct()
    {
        return view('admin.report.report_receive_product',[
            'pro' => $this->product_impl->all()->where('company_id','=',session('company')),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function reportReceiveProductPDF(Request $request)
    {
        $param = [
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];

        $records = $this->product_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_product',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Product_All_'.$this->date_now.'.pdf');
    }

    public function reportReceiveProductPDFOther($id)
    {
        $receive_product = $this->receiveProductimpl->find($id);

        $param = [
            "month_search" => -1,
            "year_search" => -1,
            "id_receive" => $id,
            "company_id" => session('company'),
        ];

        $records = $this->product_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_product_other',[
            'data' =>  $records,
            'data_receive' =>  $receive_product,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Product_All_'.$this->date_now.'.pdf');
    }

    public function reportReceiveSupply()
    {
        return view('admin.report.report_receive_supply',[
            'sup' => $this->supply_impl->all()->where('company_id','=',session('company')),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function reportReceiveSupplyPDF(Request $request)
    {
        $param = [
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];

        $records = $this->supply_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_supply',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Supply_All_'.$this->date_now.'.pdf');
    }

    public function reportReceiveSupplyPDFOther($id)
    {
        $receive_product = $this->receiveSupplyimpl->find($id);

        $param = [
            "month_search" => "-1",
            "year_search" => "-1",
            "id_receive" => $id,
            "company_id" => session('company'),
        ];

        $records = $this->supply_impl->paginateReceiveReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);

        $pdf = PDF::loadView('admin.report.pdf.pdf_all_supply_other',[
            'data' =>  $records,
            'data_receive' =>  $receive_product,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Supply_All_'.$this->date_now.'.pdf');
    }

    public function reportRequsitionMaterial()
    {
        return view('admin.report.report_requsition_material',[
            'mat' => $this->mat_impl->all()->where('company_id','=',session('company')),
            'cat' => $this->categories->getMatCategories(),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }
    public function reportRequsitionMaterialPDF(Request $request)
    {
        $param = [
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];

        $records = $this->mat_impl->paginateRequsitionReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);

        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_material',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Material_All_'.$this->date_now.'.pdf');
    }

    public function reportRequsitionPackaging()
    {
        return view('admin.report.report_requsition_packaging',[
            'pac' => $this->packaging_impl->all()->where('company_id','=',session('company')),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }
    public function reportRequsitionPackagingPDF(Request $request)
    {
        $param = [
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
        ];

        $records = $this->packaging_impl->paginateRequsitionReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_packaging',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Packaging_All_'.$this->date_now.'.pdf');
    }

    public function reportRequsitionPackagingPdfOther($id)
    {
        $get_requsition = $this->requsitionPackagingimpl->find($id);

        $param = [
            "item_search" => -1,
            "month_search" => -1,
            "year_search" => -1,
            "id_requsition" => $id,
            "company_id" => session('company'),
        ];
        // $records = $this

        // $records = $this->mat_impl->paginateRequsitionReport($param);
        $records = $this->requsitionPackagingimpl->requsitionDataForReport($id);
        $records = $this->getqtyReturn($records);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        // dd($records);

        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_packaging_other
        ',[
            'data' =>  $records,
            'data_requsition' =>  $get_requsition,
            'com_logo' =>  $company->logo
        ]);
        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Packaging_All.pdf');
    }

    public function reportRequsitionProduct()
    {
        return view('admin.report.report_requsition_product',[
            'pro' => $this->product_impl->all()->where('company_id','=',session('company')),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }
    public function reportRequsitionProductPDF(Request $request)
    {
        $param = [
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
        ];

        $records = $this->product_impl->paginateRequsitionReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_product',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Product_All_'.$this->date_now.'.pdf');
    }
    public function reportRequsitionProductPdfOther($id)
    {
        $requsition_product = $this->requsitionProductimpl->find($id);

        $param = [
            "month_search" => "-1",
            "year_search" => "-1",
            "id_requsition" => $id,
            "company_id" => session('company'),
        ];

        $records = $this->product_impl->paginateRequsitionReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_product_other',[
            'data' =>  $records,
            'data_requsition' =>  $requsition_product,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Product_Other_'.$this->date_now.'.pdf');
    }

    public function reportRequsitionSupply()
    {
        return view('admin.report.report_requsition_supply',[
            'sup' => $this->supply_impl->all()->where('company_id','=',session('company')),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function reportRequsitionSupplyPDF(Request $request)
    {
        $param = [
            "company_id" => $request->company_id,
            "item_search" => $request->item_search,
            "month_search" => $request->month_search,
            "year_search" => $request->year_search,
        ];

        $records = $this->supply_impl->paginateRequsitionReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_supply',[
            'data' =>  $records,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);
        return $pdf->download('Supply_All_'.$this->date_now.'.pdf');
    }
    public function reportRequsitionSupplyPdfOther($id)
    {

        $requsition_supply = $this->requsitionSupplyimpl->find($id);

        $param = [
            "month_search" => "-1",
            "year_search" => "-1",
            "id_requsition" => $id,
            "company_id" => session('company'),
        ];

        $records = $this->supply_impl->paginateRequsitionReport($param);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_supply_other',[
            'data' =>  $records,
            'data_requsition' =>  $requsition_supply,
            'com_logo' =>  $company->logo
        ]);

        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);
        return $pdf->download('Supply_Other_'.$this->date_now.'.pdf');
    }

    public function reportRequsitionMaterialPdfOther($id)
    {
        $get_requsition = $this->requsitionMaterialimpl->find($id);

        $param = [
            "item_search" => -1,
            "month_search" => -1,
            "year_search" => -1,
            "id_requsition" => $id,
            "company_id" => session('company'),
        ];
        // $records = $this

        // $records = $this->mat_impl->paginateRequsitionReport($param);
        $records = $this->requsitionMaterialimpl->requsitionDataForReport($id);
        $records = $this->getWeightReturn($records);
        $sess_com = session('company');
        $company = $this->companyRepository->find($sess_com);
        // dd($records);

        // dd($records);
        $pdf = PDF::loadView('admin.report.pdf.pdf_all_req_material_other
        ',[
            'data' =>  $records,
            'data_requsition' =>  $get_requsition,
            'com_logo' =>  $company->logo
        ]);
        $pdf->setWarnings(false)->setPaper('a4', 'landscape')->getDomPDF()->set_option("enable_php", true);

        return $pdf->download('Material_All.pdf');
    }

    private function getWeightReturn($records){
        foreach($records as $requisitionMaterial) {
            $materialCuts  = $requisitionMaterial->materialCutReturns->filter(function ($materialCutReturn) {
                $materialCutReturn->weight_r = -1;
                return $materialCutReturn->action == 1;
            });
            $materialReturns  = $requisitionMaterial->materialCutReturns->filter(function ($materialCutReturn) {
                return $materialCutReturn->action == 2;
            });
            foreach ($materialReturns as $materialReturn) {
                if ($obj = $materialCuts->firstWhere('material_lot_id',$materialReturn->material_lot_id)) {
                    $obj->weight_r = $materialReturn->weight;
                    $obj->r_date = $materialReturn->datetime;
                    $obj->r_updateBy = $materialReturn->updateBy->employee->fname;
                    $obj->r_createBy = $materialReturn->createBy->employee->fname;

                }
            }
            $requisitionMaterial->materialCutReturns  = $materialCuts;
        }
        return $records;
    }

    private function getqtyReturn($records){
        foreach($records as $requsitionpackaging) {
            $packagingCut  = $requsitionpackaging->packagingCutReturns->filter(function ($packagingCutReturn) {
                $packagingCutReturn->qty_r = -1;
                return $packagingCutReturn->action == 1;
            });
            $packagingReturns  = $requsitionpackaging->packagingCutReturns->filter(function ($packagingCutReturn) {
                return $packagingCutReturn->action == 2;
            });
            foreach ($packagingReturns as $packagingReturn) {
                if ($obj = $packagingCut->firstWhere('packaging_lot_id',$packagingReturn->packaging_lot_id)) {
                    $obj->qty_r = $packagingReturn->qty + $packagingReturn->met_waste;
                    $obj->met_good_re = $packagingReturn->met_good;
                    $obj->met_waste_re = $packagingReturn->met_waste;
                    $obj->met_claim_re = $packagingReturn->met_claim;
                    $obj->met_destroy_re = $packagingReturn->met_destroy;
                    $obj->date_re = $packagingReturn->datetime;
                }
            }
            $requsitionpackaging->packagingCutReturns  = $packagingCut;
        }
        return $records;
    }
}
