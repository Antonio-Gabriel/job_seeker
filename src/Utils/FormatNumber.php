<?php

function formatNumber($amount)
{
    $formatter = new NumberFormatter('AOA',  NumberFormatter::CURRENCY);
    return str_replace("AOA", "KZ", $formatter->formatCurrency($amount, 'AOA') . PHP_EOL);
}
