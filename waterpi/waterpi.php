<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WaterPi!";

$adapter = new RPins\Adapter\SocketAdapter();
$switch = new \RPins\InPin(7);
$switch->setAdapter($adapter);

$led = new \RPins\OutPin(12);
$led->setAdapter($adapter);

$on = false;
while (true) {
    if (!$on && $switch->on()) {
        echo "Switched on!\n";
        $led->on();
        $on = true;
    }
    if ($on && $switch->off()) {
        echo "Switched off!\n";
        $led->off();
        $on = false;
    }
    usleep(100000);
}
