<?php
/**
 * @package RPins
 *
 */

namespace RPins;

class Pin
{
    private $adapter;
    private $pin;

    private $open = false;

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
    }

    protected function getAdapter()
    {
        if (!isset($this->adapter)) {
            $this->adapter = new NullAdapter();
        }
        return $this->adapter;
    }

    protected function open()
    {
        if (!$this->open) {
            $this->getAdapter()->open($this->getPin(), Adapter::OUT);
        }
        $this->open = true;
    }

    /**
     * Turns power on the pin
     */
    public function on()
    {
        $this->getAdapter()->write($this->getPin(), Adapter::HIGH);
    }

    public function off()
    {
        $this->getAdapter()->write($this->getPin(), Adapter::LOW);
    }
}
