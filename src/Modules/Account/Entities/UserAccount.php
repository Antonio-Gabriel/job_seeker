<?php

namespace SpeackWithUs\Modules\Account\Entities;

use SpeackWithUs\Domain\{Entity, Result};
use SpeackWithUs\Modules\Account\Entities\Dto\AccountProps;

use SpeackWithUs\Modules\Account\Validator\Password;

class UserAccount extends Entity
{
    public ?int $id;
    public int $userId;
    public string $password;
    public string $image;
    public string $area;

    private function __construct(AccountProps $props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    private static function againstNullOrEmpty(
        int $userId,
        string $password
    ) {
        if (
            $userId ==  0
            || $password == ""
        ) {
            return false;
        }

        return true;
    }

    public static function execute(AccountProps $props, ?int $id = null)
    {
        $bulkValidator = UserAccount::againstNullOrEmpty(
            $props->userId,
            $props->password,
            $props->area
        );

        if (!$bulkValidator) {
            return Result::Fail("Por favor, verifique se os dados estão devidamente preenchidos!");
        }

        $props->password = Password::encrypt(
            $props->password
        );

        $accountProps = new UserAccount($props, $id);

        return Result::Ok($accountProps);
    }
}
