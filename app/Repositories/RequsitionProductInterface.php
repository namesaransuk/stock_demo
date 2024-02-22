<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RequsitionProductInterface extends BaseInterface
{
    public function count($param,$paper_status,$ins_cut):int;
    public function paginate($param,$paper_status,$ins_cut):Collection;
    public function getAllRequsitionProduct($param,$name,$paper_status,$ins_cut):Collection;
}

