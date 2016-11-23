<?php

namespace App\Contracts;

interface SettingsContract extends \ArrayAccess
{
    public function get($key, $else = null);
}