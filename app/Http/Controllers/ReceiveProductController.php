<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryInterface;
use App\Repositories\CompanyInterface;
use App\Repositories\InspectTemplateInterface;
use App\Repositories\MaterialInterface;
use App\Repositories\ProductInterface;
use App\Repositories\ProductLotInterface;
use App\Repositories\ProductUnitInterface;
use App\Repositories\ReceiveProductInterface;
use App\Repositories\UnitInterface;
use Illuminate\Http\Request;

class ReceiveProductController extends Controller
{
    private $unitRepository;
    private $productUnitRepository;
    private $companyRepository;
    private $categoryRepository;
    private $receiveProductRepository;
    private $productLotRepository;
    private $productRepository;
    private $inspectTemplateRepository;

    public function __construct(UnitInterface $unitRepository, ProductUnitInterface $productUnitRepository, CompanyInterface $companyRepository,CategoryInterface $categoryRepository, ReceiveProductInterface $receiveProductRepository, ProductLotInterface $productLotRepository, InspectTemplateInterface $inspectTemplateRepository,ProductInterface $productRepository)
    {
        $this->unitRepository = $unitRepository;
        $this->productUnitRepository = $productUnitRepository;
        $this->companyRepository = $companyRepository;
        $this->categoryRepository = $categoryRepository;
        $this->receiveProductRepository = $receiveProductRepository;
        $this->productLotRepository = $productLotRepository;
        $this->inspectTemplateRepository = $inspectTemplateRepository;
        $this->productRepository = $productRepository;

    }
    public function viewListProduct()
    {
        return view('receive_product.list_receive_product');
    }

    public function viewCreateReceiveProduct()
    {
        $units = $this->unitRepository->all()->sortBy('name');
        $productunits = $this->productUnitRepository->all()->sortBy('name');
        $companys = $this->companyRepository->all();
        $categorys = $this->categoryRepository->all()->sortBy('name');
        $products = $this->productRepository->all()->where('company_id','=',session('company'))->sortBy('name');
        return view('receive_product.create_receive_product',compact('units','productunits','companys','categorys','products'));

    }

    public function viewEditReceiveProduct($id)
    {
        $product_lot_id = $id;
        $receiveproduct = $this->receiveProductRepository->find($product_lot_id);
        $units = $this->unitRepository->all()->sortBy('name');
        $productunits = $this->productUnitRepository->all()->sortBy('name');
        $companys = $this->companyRepository->all();
        $categorys = $this->categoryRepository->all()->sortBy('name');
        $products = $this->productRepository->all()->where('company_id','=',session('company'))->sortBy('name');
        return view('receive_product.edit_receive_product',compact('product_lot_id','receiveproduct','units','productunits','companys','categorys','products'));
    }
    public function viewHistoryEditReceiveProduct($id)
    {
        $product_lot_id = $id;
        $receiveproduct = $this->receiveProductRepository->find($product_lot_id);
        $units = $this->unitRepository->all();
        $productunits = $this->productUnitRepository->all();
        $companys = $this->companyRepository->all();
        $categorys = $this->categoryRepository->all();
        $products = $this->productRepository->all();
        return view('receive_product.history_receive_product',compact('product_lot_id','receiveproduct','units','productunits','companys','categorys','products'));
    }

    public function checkReceiveProduct(){
        return view('receive_product.list_inspect_receive_product');
    }

    public function viewCheckProduct($id)
    {
        $product_lot_id = $id;
        $pro_lot_detail = $this->productLotRepository->find($product_lot_id);
        $pro_detail = $this->productRepository->find($pro_lot_detail->product_id);
        $receive_detail = $this->receiveProductRepository->find($pro_lot_detail->receive_product_id);
        $inspect_templates = $this->inspectTemplateRepository->all();
       return view('receive_product.inspect_product',compact('product_lot_id','pro_lot_detail','receive_detail','inspect_templates','pro_detail'));
    }

    public function viewPendingReceiveProduct()
    {
        return view('receive_product.list_pending_receive_product');
    }

    public function viewHistoryReceiveProduct()
    {
        return view('receive_product.history_master_receive_product');
    }
}
