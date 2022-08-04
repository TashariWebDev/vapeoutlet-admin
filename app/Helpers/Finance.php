<?php


use JetBrains\PhpStorm\Pure;

if (!function_exists('to_cents')) {
    function to_cents($amount): float|int
    {
        return (float)$amount * 100;
    }
}

if (!function_exists('to_rands')) {
    function to_rands($amount): float
    {
        return (float)$amount / 100;
    }
}

if (!function_exists('money')) {
    #[Pure] function money($amount): string
    {
        return 'R ' . number_format((int)$amount, 2);
    }
}

if (!function_exists('profit_percentage')) {
    function profit_percentage($price, $cost): string
    {
        if ($cost == 0) {
            return '100%';
        }

        return number_format((($price - $cost) / $cost) * 100, 2) . '%';
    }
}

if (!function_exists('vat')) {
    #[Pure] function vat($amount): float|int
    {
        return (float)($amount) - (float)ex_vat($amount);
    }
}

if (!function_exists('ex_vat')) {
    function ex_vat($amount): float|int
    {
        return (float)$amount / 1.15;
    }
}
