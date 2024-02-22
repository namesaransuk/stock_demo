<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PackagingLotInterface extends BaseInterface
{

    public function getAllPackagingLot($id):Collection;
    public function getPackagingLotByPackagingId($id):Collection;
    public function getLotRemainById($id):Collection;
    public function getData($param):Collection;

}

