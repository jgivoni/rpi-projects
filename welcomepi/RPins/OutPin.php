<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

/**
 * A digital out pin that can only have two states: On or Off
 */
class OutPin extends Pin
{
    /**
     * @var int
     */
    private $intensity = Adapter::INTENSITY_LOW;

    /**
     * OutPin constructor.
     *
     * @param int $pin
     */
    public function __construct(int $pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_OUT);
    }

    /**
     * @param int $intensity
     */
    protected function setIntensity(int $intensity): void
    {
        $this->intensity = $intensity;
        $this->open($intensity);
        $this->getAdapter()->write($this->getPin(), $this->intensity);
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
}
