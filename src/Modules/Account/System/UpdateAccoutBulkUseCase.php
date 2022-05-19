<?php

namespace SpeackWithUs\Modules\Account\System;

use SpeackWithUs\Domain\Result;
use SpeackWithUs\Modules\Account\Interfaces\IAccountRepository;

class UpdateAccoutBulkUseCase
{
    private IAccountRepository $accountRepository;

    public function __construct(IAccountRepository $_accountRepository)
    {
        $this->accountRepository = $_accountRepository;
    }

    public function execute(array ...$props)
    {
        $statement = $this->accountRepository->updateAccountBulk(
            ...$props
        );

        if ($statement) {
            return Result::Ok($statement);
        }
    }
}
