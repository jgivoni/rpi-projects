<?php

namespace RPins\Adapter;

class SocketAdapter extends BaseAdapter
{
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

    public function open($pin, $direction)
    {
        $this->send('open ' . $pin . ' ' . $direction);
    }

    public function write($pin, $intensity)
    {
        $this->send('write ' . $pin . ' ' . $intensity);
    }

    public function close($pin)
    {
        $this->send('close ' . $pin);
    }

}
