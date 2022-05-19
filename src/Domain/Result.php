<?php

namespace SpeackWithUs\Domain;

class Result
{
    private bool $isSuccess;
    private $error;

    protected $value;

    public function  __construct(
        bool $isSuccess,
        $error,
        $value = null
    ) {
        if ($isSuccess && $error) {
            # InvalidOperation: A result cannot be successful and contain an error"            
            # throw new \Exception("InvalidOperation: A result cannot be successful and contain an error");
        }

        if (!$isSuccess && !$error) {
            # InvalidOperation: A failing result needs to contain an error message
            # throw new \Exception("InvalidOperation: A failing result needs to contain an error message");
        }

        $this->isSuccess = $isSuccess;
        $this->error = $error;
        $this->value = $value;
    }

    public function getValue()
    {
        // Return the value
        if (!$this->isSuccess) {
            throw new \Exception("Can't get the value of an error result. Use 'errorValue' instead.");
        }

        return $this->value;
    }

    public function errorValue()
    {
        // Return an error value
        return $this->error;
    }

    public static function Ok($value)
    {
        // Return OK and the value
        return new Result(true, null, $value);
    }

    public static function Fail($error)
    {
        // Return Fail and the value
        return new Result(true, $error);
    }
}
