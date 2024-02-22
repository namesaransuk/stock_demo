<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RequsitionPackagingInterface extends BaseInterface
{
    public function count($param,$paper_status,$ins_return,$ins_cut):int;
    public function paginate($param,$paper_status,$ins_return,$ins_cut):Collection;
    public function getAllRequsitionPackaging($param,$name,$paper_status,$ins_return,$ins_cut):Collection;
    public function countClaim($param):int;
    public function paginateClaim($param);
}

