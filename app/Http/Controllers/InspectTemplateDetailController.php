<?php

namespace App\Http\Controllers;

use App\Repositories\InspectTemplateInterface;
use App\Repositories\InspectTopicInterface;
use Illuminate\Http\Request;

class InspectTemplateDetailController extends Controller
{
    private $inspectTopicRepository;
    private $inspectTemplateRepository;

    public function __construct(InspectTopicInterface $inspectTopicRepository, InspectTemplateInterface $inspectTemplateRepository)
    {
        $this->inspectTopicRepository = $inspectTopicRepository;
        $this->inspectTemplateRepository = $inspectTemplateRepository;
    }

    // public function list()
    // {
    //     $inspect_topics = $this->inspectTopicRepository->all();
    //     $inspect_templates = $this->inspectTemplateRepository->all();
    //     return view('admin.inspect_template_details',compact('inspect_topics','inspect_templates'));
    // }
}
