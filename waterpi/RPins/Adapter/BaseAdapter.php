<?php

namespace RPins\Adapter;

abstract class BaseAdapter implements AdapterInterface
{
    const DIRECTION_IN = 0;
    const DIRECTION_OUT = 1;
    const DIRECTION_OUT_PWM = 2;

    const INTENSITY_HIGH = 1;
    const INTENSITY_LOW = 0;

    const PULL_OFF = 0;
    const PULL_DOWN = 1;
    const PULL_UP = 2;

    const POLL_LOW = 1;
    const POLL_HIGH = 2;
    const POLL_BOTH = 3;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param bool $debug
     * @return \RPins\Adapter\BaseAdapter
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }
}
