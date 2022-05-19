<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

use SpeackWithUs\Modules\Project\Entities\Project;

class UpdateProjectUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute(ProjectProps $request, int $id)
    {
        $project = Project::execute(
            new ProjectProps(
                $request->reference,
                $request->categoryId,
                $request->name,
                $request->description,
                $request->habilities,
                $request->price,
                $request->createdAt,
                $request->finishedAt
            )
        );

        $error = $project->errorValue();

        if ($error) {
            return Result::Fail($project->errorValue());
        }

        $statement = $this->projectRepository->update(
            $project->getValue()->props,
            $id
        );

        if ($statement) {
            return Result::Ok("Project actualizado com sucesso!");
        }
    }
}
