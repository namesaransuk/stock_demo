<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ReceiveSupplyInterface extends BaseInterface
{
    public function count($param,$paper_status):int;
    public function paginate($param,$paper_status):Collection;
    public function getAllReceiveSupplies($param,$name,$paper_status):Collection;

    public function getTemplateDetailByTemplateID($id);
    public function countPending():int;
    public function paginatePendingListReceiveSupplies($param):Collection;
    public function getAllPendingReceiveSupplies($name):Collection;


}

