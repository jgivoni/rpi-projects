<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "Starting WelcomePi!" . PHP_EOL;

$adapter = new RPins\Adapter\SocketAdapter();
$led = new \RPins\AnalogOutPin(12);
$led->setAdapter($adapter);

$sensor = new \RPins\InPin(7);
$sensor->setAdapter($adapter);

while (true) {
    if ($sensor->on()) {
        $led->fadeIn(1000);
        for ($i = 0; $i < 30; $i++) {
            sleep(1);
            // Poll regularly to let sensor drain to actual state
            $sensor->getState();
        }
    } else {
        $led->fadeOut(3000, function () use ($sensor) {
            return $sensor->on();
        });
    }
    usleep(100000);
}
