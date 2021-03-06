<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

abstract class Pin
{
    private $adapter;
    private $pin;

    private $direction;
    private $open = false;

    /**
     * @param $pin Pin number, sequentially numbered from 1-40, starting from upper left corner (not GPIO numbers)
     */
    public function __construct($pin)
    {
        $this->pin = $pin;
    }

    protected function getPin()
    {
        return $this->pin;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        $this->open();
    }

    protected function getAdapter(): Adapter
    {
        if (!isset($this->adapter)) {
            $this->adapter = new NullAdapter();
        }
        return $this->adapter;
    }

    protected function setDirection(int $direction)
    {
        $this->direction = $direction;
        return $this;
    }

    protected function open($arg2 = '')
    {
        if (!$this->open) {
            $this->open = $this->getAdapter()->open($this->getPin(), $this->direction, $arg2);
        }
    }

    protected function close()
    {
        if (!$this->open) {
            $this->getAdapter()->close($this->getPin());
            $this->open = false;
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}
