<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository ;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function list(){
        return view('admin.category');
    }
}
