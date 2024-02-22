<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SetPlanInterface extends BaseInterface
{
    public function crud($request);
}


