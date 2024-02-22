<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryReceivePackagingInterface extends BaseInterface
{
    function historyReceivePackaging($id):Collection;
}

