<?php

namespace RPins\Adapter;

class SocketAdapter extends BaseAdapter
{
    const READ_TIMEOUT_MS = 100;

    private $socket;

    protected function getSocket()
    {
        if (!isset($this->socket)) {
            $this->socket = fsockopen('gpio', '7695');
        }
        return $this->socket;
    }

    protected function send($command)
    {
        fwrite($this->getSocket(), $command . PHP_EOL);
    }

    protected function flushInput()
    {
        fread($this->getSocket(), 10000);
    }

    protected function receive($length)
    {
        $input = '';
        for ($i = 0; $i < 10; $i++) {
            $input .= fread($this->getSocket(), $length - strlen($input));
            if (strlen($input) == $length) {
                break;
            }
            usleep(self::READ_TIMEOUT_MS * 100);
        }
        return $input;
    }

    public function open($pin, $direction, $arg2)
    {
        $this->send('open ' . $pin . ' ' . $direction . ' ' . $arg2);
    }

    public function write($pin, $intensity)
    {
        $this->send('write ' . $pin . ' ' . $intensity);
    }

    public function read($pin)
    {
        $this->flushInput();
        $this->send('read ' . $pin);
        $input = $this->receive(1);
        return $input == '' ? null : (bool) $input;
    }

    public function close($pin)
    {
        $this->send('close ' . $pin);
    }

    public function pwmSetClockDivider($divider)
    {
        $this->send('pwmSetClockDivider ' . $divider);
    }

    public function pwmSetRange($pin, $range)
    {
        $this->send('pwmSetRange ' . $pin . ' ' . $range);
    }

    public function pwmSetData($pin, $data)
    {
        $this->send('pwmSetData ' . $pin . ' ' . $data);
    }

}
