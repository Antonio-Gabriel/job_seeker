<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

use SpeackWithUs\Modules\Project\Entities\Project;

class CreateProjectUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute(ProjectProps $request)
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

        $projectAlreadyExists = $this->projectRepository->findByReference(
            $request->reference
        );

        if ($projectAlreadyExists) {
            return Result::Fail("Referência do projecto já existe!");
        }

        $statement = $this->projectRepository->create(
            $project->getValue()->props
        );

        if ($statement) {
            return Result::Ok("Project cadastrado com sucesso!");
        }
    }
}
