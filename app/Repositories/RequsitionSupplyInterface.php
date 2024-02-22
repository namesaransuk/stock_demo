<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RequsitionSupplyInterface extends BaseInterface
{
    public function count($param,$paper_status):int;
    public function paginate($param,$paper_status):Collection;
    public function getAllRequsitionSupply($param,$name,$paper_status):Collection;


}

