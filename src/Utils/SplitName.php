<?php

function splitName(string $name)
{
    $split = explode(" ", $name);

    return $split[0] . " " . $split[count($split) - 1];
}
