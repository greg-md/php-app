<?php

namespace App;

class Settings implements \ArrayAccess
{
    private $storage;

    public function __construct(array $settings)
    {
        $this->storage = $settings;

        return $this;
    }

    public function get($key, $else = null)
    {
        return array_key_exists($key, $this->storage) ? $this->storage[$key] : $else;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->storage);
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
