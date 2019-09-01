<?php

namespace RPins\Adapter;

interface AdapterInterface
{
    /**
     * @param array $options
     * @return bool
     */
    public function init(array $options): bool;

    /**
     * @param int $pin
     * @param int $direction
     * @param int|null $arg2
     * @return bool
     */
    public function open(int $pin, int $direction, ?int $arg2 = null): bool;

    /**
     * @param int $pin
     * @return bool
     */
    public function close(int $pin): bool;

    /**
     * @param int $pin
     * @param int $intensity
     * @return bool
     */
    public function write(int $pin, int $intensity): bool;

    /**
     * @param int $pin
     * @return string
     */
    public function read(int $pin): ?bool;

    /**
     * @param int $divider
     * @return bool
     */
    public function pwmSetClockDivider(int $divider): bool;

    /**
     * @param int $pin
     * @param int $range
     * @return bool
     */
    public function pwmSetRange(int $pin, int $range): bool;

    /**
     * @param int $pin
     * @param string $data
     * @return bool
     */
    public function pwmSetData(int $pin, int $data): bool;
}
