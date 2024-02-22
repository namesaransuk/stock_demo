<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SupplyCutInterface extends BaseInterface
{
    public function getCutReturnById($supply_lot_id);
    public function getAllSupplyRequsitionLot($id):Collection;
    public function getData($param):Collection;
}

