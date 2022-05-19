<?php

function formatDate(string $date)
{
    $convertStringToTime = strtotime(substr($date, 0, 10));
    $formatDate = date("d/m/Y", $convertStringToTime);
    return $formatDate;
}
