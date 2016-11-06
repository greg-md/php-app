<?php

namespace App\Misc;

use App\Strategies\OptionsStrategy;
use Greg\Support\Accessor\AccessorTrait;

class Options implements \ArrayAccess
{
    use AccessorTrait;

    protected $strategy = null;

    public function __construct(OptionsStrategy $strategy)
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function reload()
    {
        $this->setAccessor($this->strategy->getActiveList());

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
