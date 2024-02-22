<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ReceiveProductInterface extends BaseInterface
{
    public function count($param,$paper_status,$inspect_ready):int;
    public function paginate($param,$paper_status,$inspect_ready):Collection;
    public function getAllReceiveProducts($param,$name,$paper_status,$inspect_ready):Collection;

    public function getTemplateDetailByTemplateID($id);
    public function countPending():int;
    public function paginatePendingListReceiveProducts($param):Collection;
    public function getAllPendingReceiveProducts($name):Collection;


}

