<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WaterPi!";

$led = new \RPins\Pin(12);
$led->setAdapter(new RPins\Adapter\SocketAdapter());

while (true) {
    $led->on();
    sleep(2);
    $led->off();
    sleep(1);
}
