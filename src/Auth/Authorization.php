<?php

namespace SpeackWithUs\Auth;

class Authorization
{
    public static function authenticate()
    {
        if (!isset($_SESSION["admin"])) {
            redirect("backoffice");
        }
    }

    public static function notAuthenticate()
    {
        if (isset($_SESSION["admin"])) {
            redirect("dashboard");
        }
    }

    public static function authenticatedUser()
    {
        if (!isset($_SESSION["user"])) {
            redirect("signIn");
        }
    }

    public static function notAuthenticatedUser()
    {
        if (isset($_SESSION["user"])) {
            redirect("profile");
        }
    }
}
