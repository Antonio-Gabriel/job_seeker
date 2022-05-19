<?php

namespace SpeackWithUs\Modules\Account\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\User\Repositories\UserRepository;

class GetAccountUseCase
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function execute(int $id)
    {
        $user = $this->userRepository->getAccountId($id);
        return Result::Ok($user);
    }
}
