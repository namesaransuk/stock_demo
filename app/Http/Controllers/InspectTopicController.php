<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryInterface;
use App\Repositories\InspectTopicInterface;
use App\Repositories\InspectTopicTypeInterface;
use Illuminate\Http\Request;

class InspectTopicController extends Controller
{
    private $inspectTopicRepository;
    private $categoryRepository;

    public function __construct(InspectTopicInterface $inspectTopicRepository, CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->inspectTopicRepository = $inspectTopicRepository;
    }

    public function list()
    {
        $categoties = $this->categoryRepository->all();
        return view('admin.inspect_topic',compact('categoties'));
    }
}
