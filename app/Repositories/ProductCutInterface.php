<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProductCutInterface extends BaseInterface
{
    public function getCutReturnById($product_lot_id);
    public function getAllProductRequsitionLot($id):Collection;
    public function getData($param):Collection;
}

