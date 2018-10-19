<?php

namespace RPins\Adapter;

abstract class BaseAdapter implements AdapterInterface {
    const DIRECTION_IN = 0;
    const DIRECTION_OUT = 1;
    const DIRECTION_OUT_PWM = 2;
    const INTENSITY_HIGH = 1;
    const INTENSITY_LOW = 0;
}
