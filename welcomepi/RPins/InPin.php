<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

/**
 * A digital in pin that can only read two states: On or Off
 */
class InPin extends Pin
{
    const MIN_READ_INTERVAL_MS = 50;

    private $on = false;
    private $changed = false;
    private $lastRead;

    public function __construct($pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_IN);
    }

    protected function readState()
    {
        $this->open(Adapter::PULL_DOWN);
        if (isset($on)) {
            if ($this->on !== $on) {
                $this->on = $on;
                $this->changed = true;
            }
        }
        $this->lastRead = microtime(true);
    }

    public function getState()
    {
        if (!isset($this->lastRead) || $this->lastRead < microtime(true) - self::MIN_READ_INTERVAL_MS / 1000) {
            $this->readState();
        }
        return $this->on;
    }

    /**
     * Returns whether or not the power is on
     */
    public function on()
    {
        return $this->getState();
    }

    public function off()
    {
        return !$this->getState();
    }

    public function changed()
    {
        $this->getState();
        $changed = $this->changed;
        $this->changed = false;
        return $changed;
    }
}
