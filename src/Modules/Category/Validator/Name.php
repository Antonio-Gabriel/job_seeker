<?php

namespace SpeackWithUs\Modules\Category\Validator;

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
