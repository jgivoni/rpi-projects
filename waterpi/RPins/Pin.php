<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

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

    protected function getAdapter(): Adapter
    {
        if (!isset($this->adapter)) {
            $this->adapter = new NullAdapter();
        }
        return $this->adapter;
    }

    protected function open()
    {
        if (!$this->open) {
            $this->getAdapter()->open($this->getPin(), Adapter::DIRECTION_OUT);
            $this->open = true;
        }
    }

    protected function close()
    {
        if (!$this->open) {
            $this->getAdapter()->close($this->getPin());
            $this->open = false;
        }
    }

    protected function setIntensity($intensity)
    {
        $this->open();
        $this->getAdapter()->write($this->getPin(), $intensity);
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

    public function __destruct()
    {
        $this->close();
    }
}
