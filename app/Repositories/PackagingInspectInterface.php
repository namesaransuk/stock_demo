<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PackagingInspectInterface extends BaseInterface
{

    public function getInspectDetailByPackagingLotID($id):Collection;

}

