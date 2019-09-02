<?php

date_default_timezone_set('Europe/Madrid');

// Coordinate precision: https://xkcd.com/2170/
$now = time();
$sunset = date_sunset($now, SUNFUNCS_RET_TIMESTAMP, '41.39', '2.16', '90') . PHP_EOL;
$sunrise = date_sunrise($now, SUNFUNCS_RET_TIMESTAMP, '41.39', '2.16', '90') . PHP_EOL;

if ($now < $sunrise || $now > $sunset) {
    echo "ON!" . PHP_EOL;
}