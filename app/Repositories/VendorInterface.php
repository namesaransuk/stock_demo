<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface VendorInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllVendors($name):Collection;

}

