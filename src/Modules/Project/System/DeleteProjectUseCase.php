<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

class DeleteProjectUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute(int $id)
    {
        $projects = $this->projectRepository->delete($id);

        if ($projects) {
            return Result::Ok("Projecto eliminado com sucesso!");
        }
    }
}
