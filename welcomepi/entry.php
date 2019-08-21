<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WelcomePi!" . PHP_EOL;

$led = new \RPins\AnalogOutPin(12);
$led->setAdapter(new RPins\Adapter\SocketAdapter());

while (true) {
    for ($i = 0; $i < 100; $i++) {
        $led->setIntensity($i / 100);
        usleep(20000);
    }
    for ($i = 100; $i > 0; $i--) {
        $led->setIntensity($i / 100);
        usleep(10000);
    }
}
