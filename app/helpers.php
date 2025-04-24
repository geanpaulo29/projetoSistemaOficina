<?php

if (!function_exists('money')) {
    function money($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}