<?php


use JetBrains\PhpStorm\Pure;

if (!function_exists('to_cents')) {
    function to_cents($amount): float|int
    {
        return (int)$amount * 100;
    }
}

if (!function_exists('to_rands')) {
    function to_rands($amount): string
    {
        return number_format(((int)$amount / 100), 2);
    }
}

if (!function_exists('money')) {
    #[Pure] function money($amount): string
    {
        return 'R ' . number_format(((int)$amount / 100), 2);
    }
}

if (!function_exists('profit_percentage')) {
    function profit_percentage($price, $cost): string
    {
        return number_format((($price - $cost) / $cost) * 100, 2) . '%';
    }
}

if (!function_exists('vat')) {
    #[Pure] function vat($amount): float|int
    {
        $amount_in_rands = to_rands($amount);
        $vat = (float)($amount_in_rands) - (float)ex_vat($amount_in_rands);

        return number_format($vat, 2);
    }
}

if (!function_exists('ex_vat')) {
    function ex_vat($amount): float|int
    {
        $amount_in_rands = to_rands($amount);
        $amount_ex_vat = (float)$amount_in_rands / 1.15;
        return number_format($amount_ex_vat, 2);
    }
}
