<?php

namespace SpeackWithUs\Modules\Project\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

class GetFilterByReferenceUseCase
{
    private IProjectRepository $projectRepository;

    public function __construct(IProjectRepository $_projectRepository)
    {
        $this->projectRepository = $_projectRepository;
    }

    public function execute(string $reference)
    {
        $projects = $this->projectRepository->filterByReference($reference);
        return Result::Ok($projects);
    }
}
