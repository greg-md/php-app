<?php

namespace App\Misc;

use App\Strategies\SettingsStrategy;
use Greg\Support\Accessor\AccessorTrait;

class Settings implements \ArrayAccess
{
    use AccessorTrait;

    protected $strategy = null;

    public function __construct(SettingsStrategy $strategy)
    {
        $this->strategy = $strategy;

        $this->reload();

        return $this;
    }

    public function reload()
    {
        $this->setAccessor($this->strategy->getList());

        return $this;
    }

    public function get($key)
    {
        return $this->getFromAccessor($key);
    }

    public function __get($name)
    {
        return $this->getFromAccessor($name);
    }

    public function offsetGet($offset)
    {
        return $this->getFromAccessor($offset);
    }

    public function offsetExists($offset)
    {
        return $this->inAccessor($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception('You are not allowed to change options.');
    }

    public function offsetUnset($offset)
    {
        throw new \Exception('You are not allowed to delete options.');
    }
}
