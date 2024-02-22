<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface InspectTopicInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllInspectTopics($name):Collection;
    public function getInspectTopicByCategoryID($id);
}

