<?php

namespace SpeackWithUs\Modules\Enrollment\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Enrollment\Interfaces\IEnrollmetRepository;

class GetAllSubscribersUsersToWorkUseCase
{
    private IEnrollmetRepository $enrollmentRepository;

    public function __construct(IEnrollmetRepository $_enrollmentRepository)
    {
        $this->enrollmentRepository = $_enrollmentRepository;
    }

    public function execute()
    {
        $subscribeJobs = $this->enrollmentRepository->getAllEnrollments();
        return Result::Ok($subscribeJobs);
    }
}
