<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

class GetProjectByIdUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute(int $id)
    {
        $project = $this->projectRepository->getById($id);
        return Result::Ok($project);
    }
}
