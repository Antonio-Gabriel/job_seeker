<?php

function calculateTotalHours(string $startDate, string $endDate)
{
    $timestampStart = strtotime($startDate);
    $timestampEnd = strtotime($endDate);

    return abs($timestampStart - $timestampEnd) / (60 * 60);
}
