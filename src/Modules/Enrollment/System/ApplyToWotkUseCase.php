<?php

namespace SpeackWithUs\Modules\Enrollment\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Enrollment\Interfaces\IEnrollmetRepository;

class ApplyToWotkUseCase
{
    private IEnrollmetRepository $enrollmentRepository;

    public function __construct(IEnrollmetRepository $_enrollmentRepository)
    {
        $this->enrollmentRepository = $_enrollmentRepository;
    }

    public function execute(int $projectId, int $userId)
    {
        $userAlreadySubscribeToThisJob = $this->enrollmentRepository->findBySubscribeJob(
            $projectId,
            $userId
        );

        if ($userAlreadySubscribeToThisJob) {
            return Result::Fail("Já estás inscrito nesse trabalho");
        }

        $subscribeToJob = $this->enrollmentRepository->applyToWork(
            $projectId,
            $userId
        );

        if ($subscribeToJob) {
            return Result::Ok("Inscrito com sucesso!");
        }
    }
}
