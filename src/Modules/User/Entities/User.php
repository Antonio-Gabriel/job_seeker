<?php

namespace SpeackWithUs\Modules\User\Entities;

use SpeackWithUs\Domain\{Entity, Result};
use SpeackWithUs\Modules\User\Entities\Dto\UserProps;

use SpeackWithUs\Modules\User\Validator\{Name, Email, Phone};

class User extends Entity
{
    public int $id;
    public string $name;
    public string $phone;
    public string $city;
    public string $district;
    public string $road;
    public string $email;
    public int $admin;
    public int $state;

    private function __construct(UserProps $props, ?int $id = null)
    {
        parent::__construct($props, $id);
    }

    private static function againstNullOrEmpty(
        string $name,
        string $phone,
        string $email
    ) {
        if (
            $phone ==  ""
            || $name == ""
            || $email == ""
        ) {
            return false;
        }

        return true;
    }

    public static function execute(UserProps $props, ?int $id = null)
    {
        if (Name::isValid($props->name)) {
            return Result::Fail("Nome informado inválido!");
        }

        if (Name::isValid($props->district)) {
            return Result::Fail("Bairro informado inválido!");
        }

        if (Name::isValid($props->road)) {
            return Result::Fail("Rua informada inválido!");
        }

        if (!Email::isValid($props->email)) {
            return Result::Fail("Email informado inválido!");
        }

        if (!Phone::isValid($props->phone)) {
            return Result::Fail("Número informado inválido!");
        }

        $bulkValidator = User::againstNullOrEmpty(
            $props->name,
            $props->phone,
            $props->email
        );

        if (!$bulkValidator) {
            return Result::Fail("Por favor, verifique se os dados estão devidamente preenchidos!");
        }

        $userProps = new User($props, $id);

        return Result::Ok($userProps);
    }
}
