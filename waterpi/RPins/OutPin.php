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
    private $intensity = Adapter::INTENSITY_LOW;

    public function __construct($pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_OUT);
    }

    protected function setIntensity($intensity)
    {
        $this->intensity = $intensity;
        $this->open($intensity);
        $this->getAdapter()->write($this->getPin(), $this->intensity);
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

}
