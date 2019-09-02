<?php

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Europe/Madrid');

echo "Starting WelcomePi!" . PHP_EOL;

$adapter = new RPins\Adapter\SocketAdapter();
$led = new \RPins\AnalogOutPin(12);
$led->setAdapter($adapter);

$sensor = new \RPins\InPin(7);
$sensor->setAdapter($adapter);

$onTime = 0;
while (true) {
    $now = time();
    $sunset = date_sunset($now, SUNFUNCS_RET_TIMESTAMP, '41.39', '2.16', '90') . PHP_EOL;
    $sunrise = date_sunrise($now, SUNFUNCS_RET_TIMESTAMP, '41.39', '2.16', '90') . PHP_EOL;

    if ($now > $sunrise && $now < $sunset) {
        $led->off();
        sleep(10);
        continue;
    }

    if ($sensor->on()) {
        if ($onTime < 1) {
            echo date('Y-m-d H:i:s') . " \x1b[33mTurning on\x1b[0m" . PHP_EOL;
            $led->fadeIn(1000);
        }
        $onTime = 300;
    } else {
        if ($onTime < 1 && $onTime > 0) {
            echo date('Y-m-d H:i:s') . " \x1b[32mTurning off\x1b[0m" . PHP_EOL;
            $led->fadeOut(60000, function () use ($sensor) {
                return $sensor->on();
            });
            $onTime = 0;
        }
    }

    usleep(100000);
    $onTime = max($onTime - 0.1, 0);
}
