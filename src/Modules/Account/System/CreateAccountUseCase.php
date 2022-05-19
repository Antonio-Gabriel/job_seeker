<?php

namespace SpeackWithUs\Modules\Account\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Account\Interfaces\IAccountRepository;

use SpeackWithUs\Modules\Account\Entities\UserAccount;
use SpeackWithUs\Modules\Account\Entities\Dto\AccountProps;

class CreateAccountUseCase
{
    private IAccountRepository $accountRepository;

    public function __construct(IAccountRepository $_accountRepository)
    {
        $this->accountRepository = $_accountRepository;
    }

    public function execute(AccountProps $props)
    {
        $account = UserAccount::execute(
            new AccountProps(
                $props->userId,
                $props->password,
                $props->image,
                $props->area
            )
        );

        $error = $account->errorValue();

        if ($error) {
            return Result::Fail($account->errorValue());
        }

        $statement = $this->accountRepository->create(
            $account->getValue()->props
        );

        if ($statement) {
            return Result::Ok("Conta criada com sucesso!");
        }
    }
}
