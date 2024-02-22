<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryReceiveMaterialInterface extends BaseInterface
{
    function historyReceiveMaterial($id):Collection;
}

