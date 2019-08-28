<?php

namespace RPins\Adapter;

/**
 * A socket adapter that communicates with jgivoni/rpi-gpio-server nodejs service
 */
class SocketAdapter extends BaseAdapter
{
    const READ_TIMEOUT_MS = 100;

    private $socket;

    protected function getSocket()
    {
        if (!isset($this->socket)) {
            $socket = fsockopen('gpio', '7695', $errno, $errstr, 60);
            if ($socket !== false) {
                stream_set_timeout($socket, 0, self::READ_TIMEOUT_MS * 1000);
                $this->socket = $socket;
                $this->receive(10000); // Flush the welcome response
            } else {
                echo "Error connecting to gpio:7695: " . $errstr;
            }
        }
        return $this->socket;
    }

    protected function send($command)
    {
        if ($this->debug) {
            echo "Out: " . $command . PHP_EOL;
        }
        $result = fwrite($this->getSocket(), $command . PHP_EOL);
        if ($result === false) {
            unset($this->socket);
        }
        return $result !== false;
    }

    protected function receive($length)
    {
        $in = fread($this->getSocket(), $length);
        if ($in === false) {
            unset($this->socket);
        }
        if ($this->debug) {
            echo "In: " . $in . PHP_EOL;
        }

        return $in === false ? '' : $in;
    }

    public function open($pin, $direction, $arg2 = '')
    {
        return $this->send('open ' . $pin . ' ' . $direction . ' ' . $arg2);
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
