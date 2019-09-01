<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

/**
 * An out pin with possibility of continuously variable intensity
 */
class AnalogOutPin extends Pin
{
    const CLOCK_DIVIDER = 8; // Specifies the frequency relative to the CPU clock
    const RANGE = 100; // Sets the range used (from 0 to this number)

    private $intensity;

    private $init = false;

    public function __construct($pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_OUT_PWM);
    }

    protected function open($arg2 = '')
    {
        parent::open($arg2);
        if (!$this->init) {
            $this->getAdapter()->pwmSetClockDivider(self::CLOCK_DIVIDER); // This is global for all PWM pins!
            $this->getAdapter()->pwmSetRange($this->getPin(), self::RANGE);
        }
        $this->init = true;
    }

    public function setIntensity($intensity)
    {
        if ($intensity != $this->getIntensity()) {
            $this->intensity = $intensity;
            $this->open();
            $this->getAdapter()->pwmSetData($this->getPin(), round(self::RANGE * $this->getIntensity()));
        }
    }

    /**
     * Turns power on the pin
     */
    public function on()
    {
        $this->setIntensity(Adapter::INTENSITY_HIGH);
    }

    public function off()
    {
        $this->setIntensity(Adapter::INTENSITY_LOW);
    }

    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * @param \RPins\int $ms Time in milliseconds for a full fade in
     * @param Callable $interruptCallback Function, if returns true, abort fade in
     */
    public function fadeIn(int $ms, $interruptCallback = null)
    {
        $sleepmu = $ms * 10;
        for ($i = round($this->getIntensity() * 100); $i <= 100; $i++) {
            $this->setIntensity($i / 100);
            usleep($sleepmu);
            if (isset($interruptCallback) && $interruptCallback()) {
                break;
            }
        }
    }

    /**
     * @param \RPins\int $ms Time in milliseconds for a full fade out
     * @param Callable $interruptCallback Function, if returns true, abort fade out
     */
    public function fadeOut(int $ms, $interruptCallback = null)
    {
        $sleepmu = $ms * 10;
        for ($i = round($this->getIntensity() * 100); $i >= 0; $i--) {
            $this->setIntensity($i / 100);
            usleep($sleepmu);
            if (isset($interruptCallback) && $interruptCallback()) {
                break;
            }
        }
    }
}
