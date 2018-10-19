<?php

namespace RPins\Adapter;

interface AdapterInterface
{
    public function open($pin, $direction, $arg2);

    public function close($pin);

    public function write($pin, $intensity);

    public function read($pin);

    public function pwmSetClockDivider($divider);

    public function pwmSetRange($pin, $range);

    public function pwmSetData($pin, $data);
}
