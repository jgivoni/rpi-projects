<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WaterPi!";

$adapter = new \RPins\Adapter\SocketAdapter();
$adapter->open(12, 1);

while (true) {
    $adapter->write(12, 1);
    sleep(2);
    $adapter->write(12, 0);
    sleep(1);
}

$adapter->close(12);
