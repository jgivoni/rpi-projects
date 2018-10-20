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
            stream_set_timeout($this->getSocket(), 0, self::READ_TIMEOUT_MS * 1000);
            $this->receive(10000); // Flush the welcome response
        }
        return $this->socket;
    }

    protected function send($command)
    {
        echo "Out: " . $command . PHP_EOL;
        fwrite($this->getSocket(), $command . PHP_EOL);
    }

    protected function receive($length)
    {
        $in = fread($this->getSocket(), $length);
        echo "In: " . $in . PHP_EOL;

        return $in === false ? '' : $in;
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
