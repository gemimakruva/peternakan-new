<?php

if (! function_exists('format_angka')) {
    function format_angka($num, $decimals = 2) {
        if ($num === null) return null;
        if (floor($num) == $num) {
            return number_format($num, 0, ',', '.');
        }
        return number_format($num, $decimals, ',', '.');
    }
}

if (! function_exists('format_uang')) {
    function format_uang($num, $decimals = 0) {
        if ($num === null) return null;
        return 'Rp. ' . format_angka($num, $decimals);
    }
}