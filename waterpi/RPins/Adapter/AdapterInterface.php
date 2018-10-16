<?php

namespace RPins\Adapter;

interface AdapterInterface
{
    public function open($pin, $direction);

    public function close($pin);

    public function write($pin, $intensity);
}
