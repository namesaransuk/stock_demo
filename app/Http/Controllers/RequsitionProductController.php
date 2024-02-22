<?php

namespace App\Http\Controllers;

use App\Repositories\ProductInterface;
use App\Repositories\RequsitionProductInterface;
use Illuminate\Http\Request;

class RequsitionProductController extends Controller
{
    private $productRepository;
    private $requsitionProductRepository;
    public function __construct(ProductInterface $productRepository,RequsitionProductInterface $requsitionProductRepository)
    {
        $this->productRepository = $productRepository;
        $this->requsitionProductRepository = $requsitionProductRepository;
    }
    public function viewListRequsitionProduct()
    {
        return view('requsition_product.list_requsition_product');
    }

    public function viewListRequsitionInspectProduct()
    {
        return view('requsition_product.list_requsition_inspect_product');
    }

    public function viewListRequsitionPendingProduct()
    {
        return view('requsition_product.list_requsition_pending_product');
    }

    public function viewListRequsitionHistoryProduct()
    {
        return view('requsition_product.list_requsition_history_product');
    }

    public function viewCreateRequsitionProduct()
    {
        $products = $this->productRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
        return view('requsition_product.create_requsition_product',compact('products'));
    }

    public function viewEditRequsitionProduct($id)
    {
        $requsition_product_id = $id;
        $products = $this->productRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
        $requsition_product = $this->requsitionProductRepository->find($id);
        // dd($requsition_product);
        return view('requsition_product.edit_requsition_product',compact('requsition_product_id','products','requsition_product'));
    }

    public function viewListHistoryRequsitionProduct()
    {
        return view('requsition_product.history_requsition_product');
    }

    public function viewHistoryEditRequsitionProduct($id)
    {
        $requsition_product_id = $id;
        $products = $this->productRepository->getAllWithStockRemain();
        $requsition_product = $this->requsitionProductRepository->find($id);
        return view('requsition_product.history_edit_requsition_product',compact('requsition_product_id','products','requsition_product'));
    }
}
