<?php

namespace SpeackWithUs\Modules\Enrollment\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Enrollment\Interfaces\IEnrollmetRepository;

class GetSubscribeWorkUseCase
{
    private IEnrollmetRepository $enrollmentRepository;

    public function __construct(IEnrollmetRepository $_enrollmentRepository)
    {
        $this->enrollmentRepository = $_enrollmentRepository;
    }

    public function execute(int $userId)
    {
        $subscribeJobs = $this->enrollmentRepository->getEnrollments($userId);
        return Result::Ok($subscribeJobs);
    }
}
