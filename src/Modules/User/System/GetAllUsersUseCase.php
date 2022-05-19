<?php

namespace SpeackWithUs\Modules\User\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\User\Interfaces\IUserRepository;

class GetAllUsersUseCase
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute()
    {
        $users = $this->userRepository->get();
        return Result::Ok($users);
    }
}
