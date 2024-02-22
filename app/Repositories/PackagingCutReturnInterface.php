<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PackagingCutReturnInterface extends BaseInterface
{
    public function getCutReturnById($packaging_lot_id);
    public function getAllPackagingRequsitionLot($id):Collection;
    public function getData($param):Collection;
}

