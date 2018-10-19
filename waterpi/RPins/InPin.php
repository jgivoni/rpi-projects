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
class InPin extends Pin
{
    private $on = false;
    private $changed = false;

    public function __construct($pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_IN);
    }

    protected function readState()
    {
        $this->open(Adapter::PULL_DOWN);
        $on = $this->getAdapter()->read($this->getPin());
        if (isset($on)) {
            if ($this->on !== $on) {
                $this->on = $on;
                $this->changed = true;
            }
        }
        return $this->on;
    }

    /**
     * Returns whether or not the power is on
     */
    public function on()
    {
        return $this->readState();
    }

    public function off()
    {
        return !$this->readState();
    }

    public function changed()
    {
        $changed = $this->changed;
        $this->changed = false;
        return $changed;
    }

    public function getState()
    {
        return $this->on;
    }
}
