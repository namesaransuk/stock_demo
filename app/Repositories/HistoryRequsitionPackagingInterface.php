<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryRequsitionPackagingInterface extends BaseInterface
{
    function historyRequsitionPackaging($id):Collection;
}

