<?php

namespace SpeackWithUs\Modules\User\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\User\Interfaces\IUserRepository;

class GetUserByIdUseCase
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute(int $userId)
    {
        $users = $this->userRepository->getById($userId);
        return Result::Ok($users);
    }
}
