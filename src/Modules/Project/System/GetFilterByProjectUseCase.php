<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

class GetFilterByProjectUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute(string $name)
    {
        $projects = $this->projectRepository->filterByName($name);
        return Result::Ok($projects);
    }
}
