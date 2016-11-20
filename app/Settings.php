<?php

namespace App;

use App\Contracts\SettingsContract;
use Greg\Support\Accessor\AccessorTrait;

class Settings implements SettingsContract
{
    use AccessorTrait;

    public function __construct($settings)
    {
        $this->setAccessor($settings);

        return $this;
    }

    public function get($key)
    {
        return $this->getFromAccessor($key);
    }

    public function __get($key)
    {
        return $this->getFromAccessor($key);
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
        throw new \Exception('You are not allowed to change settings.');
    }

    public function offsetUnset($offset)
    {
        throw new \Exception('You are not allowed to delete settings.');
    }
}
