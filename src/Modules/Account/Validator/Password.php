<?php

namespace SpeackWithUs\Modules\Account\Validator;

class Password
{
    public static function encrypt($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function comparePassword($pass, $hash)
    {
        return password_verify($pass, $hash);
    }
}
