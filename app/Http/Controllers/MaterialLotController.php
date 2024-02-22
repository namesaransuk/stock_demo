<?php

namespace App\Http\Controllers;

use App\Repositories\MaterialLotInterface;
use Illuminate\Http\Request;

class MaterialLotController extends Controller
{
    private $materialLotRepository;
    public function __construct(MaterialLotInterface $materialLotRepository)
    {
        $this->materialLotRepository = $materialLotRepository;
    }



}
