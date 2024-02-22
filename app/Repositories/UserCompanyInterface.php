<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserCompanyInterface extends BaseInterface
{
    public function getAllCompanyByUserID($id):Collection;
}

