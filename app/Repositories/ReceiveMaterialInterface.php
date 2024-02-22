<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ReceiveMaterialInterface extends BaseInterface
{
    public function printMaterials($company_id,$paper_status, $inspect_ready): Collection;
    public function count($param,$paper_status,$inspect_ready):int;
    public function paginate($param,$paper_status,$inspect_ready):Collection;
    public function getAllReceiveMaterials($param,$name,$paper_status,$inspect_ready):Collection;
    public function countPending():int;
    public function paginatePendingListReceiveMaterials($param):Collection;
    public function getAllPendingReceiveMaterials($name):Collection;
    public function findAllById($id);
    public function findMaterialLotById($id);
    public function getTemplateDetailByTemplateID($id);


}

