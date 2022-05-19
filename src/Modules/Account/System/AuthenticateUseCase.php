<?php

namespace SpeackWithUs\Modules\Account\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\User\Repositories\UserRepository;

class AuthenticateUseCase
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function execute(string $email)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            return Result::Ok($user);
        }

        return Result::Fail("Usuário ou senha inválido");
    }
}
