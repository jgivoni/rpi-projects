<?php

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Europe/Madrid');

echo "Testing WelcomePi!" . PHP_EOL;

$adapter = new RPins\Adapter\SocketAdapter();
$led = new \RPins\AnalogOutPin(12);
$led->setAdapter($adapter);

$sensor = new \RPins\InPin(7);
$sensor->setAdapter($adapter);

while (true) {
    if ($sensor->changed()) {
        if ($sensor->on()) {
            echo date('Y-m-d H:i:s') . " \x1b[33mTurning on\x1b[0m" . PHP_EOL;
            $led->fadeIn(1000);
        } else {
            echo date('Y-m-d H:i:s') . " \x1b[32mTurning off\x1b[0m" . PHP_EOL;
            $led->fadeOut(1000);
        }

        usleep(100000);
    }
}