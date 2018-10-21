<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

/**
 * An pair of pins for reading an analog signal using the step response technique
 * (Requires a setup using a capacitor, - works by measuring the capacitor charge time)
 */
class AnalogInPinPair
{
    private $adapter;

    protected $pin1;
    protected $pin2;

    public function __construct($pin1, $pin2)
    {
        $this->pin1 = $pin1;
        $this->pin2 = $pin2;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    protected function getAdapter(): Adapter
    {
        if (!isset($this->adapter)) {
            $this->adapter = new NullAdapter();
        }
        return $this->adapter;
    }

    protected function discharge()
    {
        $this->getAdapter()->open($this->pin1, Adapter::DIRECTION_OUT_PWM);
        $this->getAdapter()->pwmSetClockDivider(8);
        $this->getAdapter()->close($this->pin1);

        $this->getAdapter()->open($this->pin1, Adapter::DIRECTION_IN);
        $this->getAdapter()->open($this->pin2, Adapter::DIRECTION_OUT, Adapter::INTENSITY_LOW);
        usleep(100000);
    }

    protected function getChargeTime()
    {
        $this->getAdapter()->open($this->pin2, Adapter::DIRECTION_IN);
        $this->getAdapter()->open($this->pin1, Adapter::DIRECTION_OUT_PWM);
        $this->getAdapter()->pwmSetRange($this->pin1, 100);
        $this->getAdapter()->pwmSetData($this->pin1, 10);
        $start = microtime(true);
        while (true) {
            if ($this->getAdapter()->read($this->pin2) === true) {
                break;
            }
        }
        $end = microtime(true);
        return $end - $start;
    }

    public function getValue()
    {
        $this->discharge();
        return $this->getChargeTime();
    }

}
