<?php

function formatPriceGerman($price)
{
    if ($price == intval($price)) {
        return number_format($price, 0, ',', '.');
    } else {
        return number_format($price, 2, ',', '.');
    }
}

function darkenColor($color, $percent)
{

    $color = ltrim($color, '#');

    $red = hexdec(substr($color, 0, 2));
    $green = hexdec(substr($color, 2, 2));
    $blue = hexdec(substr($color, 4, 2));

    $red = round(($red * (100 - $percent)) / 100);
    $green = round(($green * (100 - $percent)) / 100);
    $blue = round(($blue * (100 - $percent)) / 100);

    $red = max(0, min(255, $red));
    $green = max(0, min(255, $green));
    $blue = max(0, min(255, $blue));

    return sprintf('#%02x%02x%02x', $red, $green, $blue);
}
