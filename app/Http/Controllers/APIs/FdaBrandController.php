<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FdaBrand;
use App\Repositories\FdaBrandInterface;

class FdaBrandController extends Controller
{
    private $fdaBrandRepository;

    public function __construct(FdaBrandInterface $fdaBrandRepository )
    {
        $this->fdaBrandRepository = $fdaBrandRepository;
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $create_fdaBrand = FdaBrand::create([
            "brand" => $data['brand'],
            "abbreviation" => $data['abbreviation'],
        ]);
        return $create_fdaBrand;
    }
}
