<?php

namespace App\Http\Controllers;

use App\Repositories\MaterialInterface;
use App\Repositories\RequsitionMaterialInterface;
use Illuminate\Http\Request;

class RequsitionMaterialController extends Controller
{
    private $materialRepository;
    private $requsitionMaterialRepository;

    public function __construct(MaterialInterface $materialRepository, RequsitionMaterialInterface $requsitionMaterialRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->requsitionMaterialRepository = $requsitionMaterialRepository;
    }
    public function listViewRequsitionMaterial()
    {
        return view('requsition_material.list_requsition_material');
    }

    public function listPendingRequsitionMaterial()
    {
        return view('requsition_material.list_pending_requsition_material');
    }

    public function listPendingReturnRequsitionMaterial()
    {
        return view('requsition_material.list_pending_return_requsition_material');
    }


    public function viewCreateRequsitionMaterial()
    {
        $materials = $this->materialRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
       return view('requsition_material.create_requsition_material',compact('materials'));
    }

    public function viewEditRequsitionMaterial($id)
    {
        $requsition_material_id = $id;
        $materials = $this->materialRepository->getAllWithStockRemain()->where('company_id','=',session('company'))->sortBy('name');
        $requsition_material = $this->requsitionMaterialRepository->find($requsition_material_id);
        return view('requsition_material.edit_requsition_material',compact('requsition_material_id','materials','requsition_material'));
    }

    public function viewHistoryRequsitionMaterial($id)
    {
        $requsition_material_id = $id;
        $materials = $this->materialRepository->getAllWithStockRemain();
        $requsition_material = $this->requsitionMaterialRepository->find($requsition_material_id);

        return view('requsition_material.history_requsition_material',compact('requsition_material_id','materials','requsition_material'));
    }

    public function viewListInspectRequsitionMaterial()
    {
        return view('requsition_material.list_inspect_requsition_material');
    }

    public function viewcheckRequsitionMaterial($id)
    {
        return view('requsition_material.inspect_requsition_material');
    }

    public function viewReturnRequsitionMaterial()
    {
        return view('requsition_material.list_return_requsition_material');
    }

    public function viewInspectReturnRequsitionMaterial()
    {
        return view('requsition_material.list_inspect_requsition_return_material');
    }
    public function viewHistoryMasterRequsitionMaterial()
    {
        return view('requsition_material.history_requsition_material_cut_return');
    }

    public function viewCreateReturnMaterial($id)
    {
        $requsition_material_id = $id;
        $materials = $this->materialRepository->all();
        $requsition_material = $this->requsitionMaterialRepository->find($requsition_material_id);
        return view('requsition_material.create_return_material',compact('requsition_material_id','materials','requsition_material'));
    }
}
