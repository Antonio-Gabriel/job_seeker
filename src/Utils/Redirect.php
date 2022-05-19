<?php

function redirect(string $path)
{
    header("Location: {$_ENV["URL_BASE_REDIRECT"]}{$path}");
    die();
}
