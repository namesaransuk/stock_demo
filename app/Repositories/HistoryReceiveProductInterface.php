<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryReceiveProductInterface extends BaseInterface
{
    function historyReceiveProduct($id):Collection;
}

