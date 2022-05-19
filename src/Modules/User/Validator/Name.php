<?php

namespace SpeackWithUs\Modules\User\Validator;

class Name
{
    public static function isValid(string $name)
    {
        /**
         * Examples :
         * Marcia J. Gaieta
         * Adrian'n Petter
         */
        return (!preg_match(
            "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i",
            $name
        )) ? false : true;
    }
}
