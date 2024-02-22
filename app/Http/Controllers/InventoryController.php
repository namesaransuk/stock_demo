<?php

namespace App\Http\Controllers;

use App\Repositories\MaterialInterface;
use App\Repositories\PackagingInterface;
use App\Repositories\ProductInterface;
use App\Repositories\SupplyInterface;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(MaterialInterface $mat_impl,PackagingInterface $packaging_impl,ProductInterface $product_impl,SupplyInterface $supply_impl) {
        $this->mat_impl = $mat_impl;
        $this->packaging_impl = $packaging_impl;
        $this->product_impl = $product_impl;
        $this->supply_impl = $supply_impl;
    }

    public function inventoryMaterial()
    {
        return view('admin.inventory.material',[
            'mat' => $this->mat_impl->materialList()->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventoryMaterialTest()
    {
        return view('admin.inventory.material',[
            'mat' => $this->mat_impl->materialList()->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventoryMaterialChart()
    {
        return $this->mat_impl->chartImpl();
    }

    public function inventoryPackaging()
    {
        return view('admin.inventory.packaging',[
            'mat' => $this->packaging_impl->all()->where('record_status','=','1')->where('company_id','=',session('company'))->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventoryPackagingTest()
    {
        return view('admin.inventory.packaging',[
            'mat' => $this->packaging_impl->all()->where('record_status','=','1')->where('company_id','=',session('company'))->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventoryPackagingChart()
    {
        return $this->packaging_impl->chartImpl();
    }

    //
    public function inventoryProduct()
    {
        return view('admin.inventory.product',[
            'mat' => $this->product_impl->all()->where('record_status','=','1')->where('company_id','=',session('company'))->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventoryProductTest()
    {
        return view('admin.inventory.product',[
            'mat' => $this->product_impl->all()->where('record_status','=','1')->where('company_id','=',session('company'))->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventoryProductChart()
    {
        return $this->product_impl->chartImpl();
    }

    //
    public function inventorySupply()
    {
        return view('admin.inventory.supply',[
            'mat' => $this->supply_impl->all()->where('record_status','=','1')->where('company_id','=',session('company'))->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventorySupplyTest()
    {
        return view('admin.inventory.supply',[
            'mat' => $this->supply_impl->all()->where('record_status','=','1')->where('company_id','=',session('company'))->sortBy("name"),
            'monthAll' => monthAll(),
            'yearFive' => yearFive(),
        ]);
    }

    public function inventorySupplyChart()
    {
        return $this->supply_impl->chartImpl();
    }
}
