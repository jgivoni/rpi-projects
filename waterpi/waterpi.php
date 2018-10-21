<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WaterPi!" . PHP_EOL;

$adapter = new RPins\Adapter\SocketAdapter();
$adapter->setDebug(false);
$sensor = new \RPins\AnalogInPinPair(12, 15);
$sensor->setAdapter($adapter);

while (true) {
    echo $sensor->getValue() . PHP_EOL;
    sleep(1);
}
