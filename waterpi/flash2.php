<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Another flashing led!";

$led = new \RPins\OutPin(12);
$led->setAdapter(new RPins\Adapter\SocketAdapter());

while (true) {
    $led->on();
    sleep(2);
    $led->off();
    sleep(1);
}
