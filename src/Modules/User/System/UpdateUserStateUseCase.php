<?php

namespace SpeackWithUs\Modules\User\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\User\Interfaces\IUserRepository;

class UpdateUserStateUseCase
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute(int $userId)
    {

        $user = $this->userRepository->getById($userId);

        $statement = $this->userRepository->updateUserState(
            $userId,
            !intval($user[0]["estado"])
        );

        if ($statement) {
            return Result::Ok("Estado actualizado com sucesso");
        }
    }
}
