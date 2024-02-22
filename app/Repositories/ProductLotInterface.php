<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProductLotInterface extends BaseInterface
{

    public function getAllProductLot($id):Collection;
    public function getLotRemainById($id):Collection;
    public function getData($param):Collection;

}

