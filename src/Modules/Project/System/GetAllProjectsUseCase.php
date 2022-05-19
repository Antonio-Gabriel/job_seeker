<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

class GetAllProjectsUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute()
    {
        $projects = $this->projectRepository->get();
        return Result::Ok($projects);
    }
}
