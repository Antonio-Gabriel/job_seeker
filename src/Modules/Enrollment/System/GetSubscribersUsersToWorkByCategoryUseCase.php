<?php

namespace SpeackWithUs\Modules\Enrollment\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Enrollment\Interfaces\IEnrollmetRepository;

class GetSubscribersUsersToWorkByCategoryUseCase
{
    private IEnrollmetRepository $enrollmentRepository;

    public function __construct(IEnrollmetRepository $_enrollmentRepository)
    {
        $this->enrollmentRepository = $_enrollmentRepository;
    }

    public function execute(int $categoryId)
    {
        $subscribeJobs = $this->enrollmentRepository->getEnrollmentsByCategory($categoryId);
        return Result::Ok($subscribeJobs);
    }
}
