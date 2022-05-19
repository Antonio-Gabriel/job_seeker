<?php

namespace SpeackWithUs\Modules\Enrollment\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Enrollment\Interfaces\IEnrollmetRepository;

class ApprovedUserToJobUseCase
{
    private IEnrollmetRepository $enrollmentRepository;

    public function __construct(IEnrollmetRepository $_enrollmentRepository)
    {
        $this->enrollmentRepository = $_enrollmentRepository;
    }

    public function execute(int $projectId, int $userId)
    {
        $approvedToJob = $this->enrollmentRepository->approvedToWork(
            $projectId,
            $userId
        );

        if ($approvedToJob) {
            return Result::Ok("Aprovado com sucesso");
        }

        return Result::Fail("Erro ao aprovar para a vaga!");
    }
}
