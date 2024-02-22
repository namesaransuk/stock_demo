<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryRequsitionSupplyInterface extends BaseInterface
{
    function historyRequsitionSupply($id):Collection;
}

