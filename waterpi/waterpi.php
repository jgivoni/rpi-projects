<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WaterPi!";

$switch = new \RPins\InPin(12);
$led->setAdapter(new RPins\Adapter\SocketAdapter());

$on = false;
while (true) {
    if (!$on && $switch->on()) {
        echo "Switched on!\n";
        $on = true;
    }
    if ($on && $switch->off()) {
        echo "Switched off!\n";
        $on = false;
    }
    usleep(100000);
}
