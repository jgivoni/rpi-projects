<?php
/**
 * @package RPins
 *
 */

namespace RPins;

use RPins\Adapter\BaseAdapter as Adapter;

abstract class Pin
{
    /**
     * @var \RPins\Adapter\BaseAdapter
     */
    private $adapter;

    /**
     * @var int
     */
    private $pin;

    /**
     * @var int
     */
    private $direction;

    /**
     * @var bool
     */
    private $open = false;

    /**
     * @param int $pin Pin number, sequentially numbered from 1-40, starting from upper left corner (not GPIO numbers)
     */
    public function __construct(int $pin)
    {
        $this->pin = $pin;
    }

    /**
     * @return int
     */
    protected function getPin(): int
    {
        return $this->pin;
    }

    /**
     * @param Adapter $adapter
     */
    public function setAdapter(Adapter $adapter): void
    {
        $this->adapter = $adapter;
    }

    /**
     * @return Adapter
     */
    protected function getAdapter(): Adapter
    {
        if (!isset($this->adapter)) {
            $this->adapter = new NullAdapter();
        }
        return $this->adapter;
    }

    /**
     * @param int $direction
     * @return \RPins\Pin
     */
    protected function setDirection(int $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * @param int|null $arg2
     */
    protected function open(?int $arg2 = null): void
    {
        if (!$this->open) {
            $this->open = $this->getAdapter()->open($this->getPin(), $this->direction, $arg2);
        }
    }

    /**
     *
     */
    protected function close(): void
    {
        if (!$this->open) {
            $this->getAdapter()->close($this->getPin());
            $this->open = false;
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->close();
    }
}
