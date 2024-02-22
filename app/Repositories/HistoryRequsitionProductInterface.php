<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface HistoryRequsitionProductInterface extends BaseInterface
{
    function historyRequsitionProduct($id):Collection;
}

