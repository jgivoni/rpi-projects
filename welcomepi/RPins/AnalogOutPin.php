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

    /**
     * @var float
     */
    private $intensity;

    /**
     * @var bool
     */
    private $init = false;

    /**
     * AnalogOutPin constructor.
     *
     * @param int $pin
     */
    public function __construct(int $pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_OUT_PWM);
    }

    /**
     * @param int|null $arg2
     */
    protected function open(?int $arg2 = null): void
    {
        if (!$this->init) {
            // Init without gpiomem to be able to use with PWM
            $this->getAdapter()->init([
                'gpiomem' => false,
            ]);
        }
        parent::open($arg2);
        if (!$this->init) {
            $this->getAdapter()->pwmSetClockDivider(self::CLOCK_DIVIDER); // This is global for all PWM pins!
            $this->getAdapter()->pwmSetRange($this->getPin(), self::RANGE);
        }
        $this->init = true;
    }

    /**
     * Sets the intensity of the output (0-1)
     *
     * @param float $intensity
     */
    public function setIntensity(float $intensity): void
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
    public function on(): void
    {
        $this->setIntensity(Adapter::INTENSITY_HIGH);
    }

    /**
     *
     */
    public function off(): void
    {
        $this->setIntensity(Adapter::INTENSITY_LOW);
    }

    /**
     * @return float
     */
    public function getIntensity(): ?float
    {
        return $this->intensity;
    }

    /**
     * @param \RPins\int $ms Time in milliseconds for a full fade in
     * @param Callable $interruptCallback Function, if returns true, abort fade in
     */
    public function fadeIn(int $ms, $interruptCallback = null): void
    {
        $interval = 1000 / $ms;
        for ($i = round($this->getIntensity() * 100); $i <= 100; $i = $i + $interval) {
            $this->setIntensity($i / 100);
            usleep(10000);
            if (isset($interruptCallback) && $interruptCallback()) {
                break;
            }
        }
    }

    /**
     * @param \RPins\int $ms Time in milliseconds for a full fade out
     * @param Callable $interruptCallback Function, if returns true, abort fade out
     */
    public function fadeOut(int $ms, $interruptCallback = null): void
    {
        $interval = 1000 / $ms;
        for ($i = round($this->getIntensity() * 100); $i >= 0; $i = $i - $interval) {
            $this->setIntensity($i / 100);
            usleep(10000);
            if (isset($interruptCallback) && $interruptCallback()) {
                break;
            }
        }
    }
}
