<?php

if (! function_exists('format_angka')) {
    function format_angka($num, $decimals = 2) {
        if (floor($num) == $num) {
            return number_format($num, 0, ',', '.');
        }

        return number_format($num, $decimals, ',', '.');
    }
}