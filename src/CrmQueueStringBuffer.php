<?php

namespace infotech\components;

class CrmQueueStringBuffer
{
    private string $buf;

    public function __construct($str = '')
    {
        $this->buf = $str;
    }

    public function put(string $str): void
    {
        $len = strlen($str);
        $this->buf = "{$this->buf}{$len}:{$str};";
    }

    public function get(): ?string
    {
        $i = strpos($this->buf, ':');
        if ($i === false) {
            return null;
        }
        $len = substr($this->buf, 0, $i);
        if ($len === false) {
            return null;
        }
        $len = (int)$len;
        $str = substr($this->buf, $i + 1, $len);
        $ch = $this->buf[$i + 1 + $len];
        if ($ch === ';') {
            $this->buf = substr($this->buf, $i + 1 + $len + 1);
            return $str;
        }
        return null;
    }

    public function __toString(): string
    {
        return $this->buf;
    }

    public static function fix($a)
    {
        $l = count($a);
        if ($l === 4) {
            return $a;
        }
        $r = [];
        while (count($a) > 3) {
            $r[] = array_shift($a);
        }
        return [implode("\n", $r), ...$a];
    }
}
