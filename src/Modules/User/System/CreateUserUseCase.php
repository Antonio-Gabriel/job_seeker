<?php

namespace SpeackWithUs\Modules\User\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\User\Entities\User;
use SpeackWithUs\Modules\User\Entities\Dto\UserProps;
use SpeackWithUs\Modules\User\Interfaces\IUserRepository;

class CreateUserUseCase
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute(UserProps $request)
    {
        $user = User::execute(
            new UserProps(
                $request->name,
                $request->phone,
                $request->city,
                $request->district,
                $request->road,
                $request->email,
                $request->admin,
                $request->state
            )
        );

        $error = $user->errorValue();

        if ($error) {
            return Result::Fail($user->errorValue());
        }

        $userAlreadyExists = $this->userRepository->findByEmail(
            $user->getValue()->props->email
        );

        if ($userAlreadyExists) {
            return Result::Fail("Usuário informado já existe");
        }

        $statement = $this->userRepository->create(
            $user->getValue()->props
        );

        if ($statement) {
            return Result::Ok($statement);
        }
    }
}
