<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryRequsitionMaterialInterface extends BaseInterface
{
    function historyRequsitionMaterial($id):Collection;
}

