<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Button switch!" . PHP_EOL;

$adapter = new RPins\Adapter\SocketAdapter();
$switch = new \RPins\InPin(7);
$switch->setAdapter($adapter);

$led = new \RPins\OutPin(12);
$led->setAdapter($adapter);

while (true) {
    if ($switch->changed()) {
        if ($switch->on()) {
            echo "Switched on!\n";
            $led->on();
        } else {
            echo "Switched off!\n";
            $led->off();
        }
    }
    usleep(10000);
}
