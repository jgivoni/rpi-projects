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

    /**
     * @var bool
     */
    private $on = false;

    /**
     * @var bool
     */
    private $changed = false;

    /**
     * @var
     */
    private $lastRead;

    /**
     * InPin constructor.
     *
     * @param int $pin
     */
    public function __construct(int $pin)
    {
        parent::__construct($pin);
        $this->setDirection(Adapter::DIRECTION_IN);
    }

    /**
     *
     */
    protected function readState(): void
    {
        $this->open(Adapter::PULL_DOWN);
        $on = $this->getAdapter()->read($this->getPin());
        if (isset($on)) {
            if ($this->on !== $on) {
                $this->on = $on;
                $this->changed = true;
            }
        }
        $this->lastRead = microtime(true);
    }

    /**
     * @return bool
     */
    public function getState(): bool
    {
        if (!isset($this->lastRead) ||
            $this->lastRead < microtime(true) - self::MIN_READ_INTERVAL_MS / 1000) {
            $this->readState();
        }
        return $this->on;
    }

    /**
     * Returns whether or not the power is on
     *
     * @return bool
     */
    public function on(): bool
    {
        return $this->getState();
    }

    /**
     * @return bool
     */
    public function off(): bool
    {
        return !$this->getState();
    }

    /**
     * @return bool
     */
    public function changed(): bool
    {
        $this->getState();
        $changed = $this->changed;
        $this->changed = false;
        return $changed;
    }
}
