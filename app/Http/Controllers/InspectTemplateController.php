<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryInterface;
use App\Repositories\InspectTemplateInterface;
use App\Repositories\InspectTopicInterface;
use App\Repositories\InspectTopicTypeInterface;
use Illuminate\Http\Request;

class InspectTemplateController extends Controller
{
    private $inspectTopicRepository;
    private $inspectTemplateRepository;
    private $categoryRepository;

    public function __construct(InspectTopicInterface $inspectTopicRepository, InspectTemplateInterface $inspectTemplateRepository,CategoryInterface $categoryRepository)
    {
        $this->inspectTopicRepository = $inspectTopicRepository;
        $this->inspectTemplateRepository = $inspectTemplateRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function list()
    {
        $categories = $this->categoryRepository->all();
        return view('admin.inspect_template',compact('categories'));
    }
    public function viewInspectTemplateDetail($id)
    {
        $template_id = $id;
        $inspect_topics = $this->inspectTopicRepository->all();
        $inspect_templates = $this->inspectTemplateRepository->all();
        return view('admin.inspect_template_details',compact('template_id','inspect_topics','inspect_templates'));
    }
}
