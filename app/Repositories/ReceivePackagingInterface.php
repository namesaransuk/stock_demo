<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ReceivePackagingInterface extends BaseInterface
{
    public function count($param,$paper_status,$inspect_ready):int;
    public function paginate($param,$paper_status,$inspect_ready):Collection;
    public function getAllReceivePackagings($param,$name,$paper_status,$inspect_ready):Collection;
    public function countPending():int;
    public function paginatePendingListReceivePackagings($param):Collection;
    public function getAllPendingReceivePackagings($name):Collection;
    public function getTemplateDetailByTemplateID($id);

}

