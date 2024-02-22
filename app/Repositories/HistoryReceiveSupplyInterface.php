<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryReceiveSupplyInterface extends BaseInterface
{
    function historyReceiveSupply($id):Collection;
}

