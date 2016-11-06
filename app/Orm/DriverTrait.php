<?php

namespace App\Orm;

use Greg\Application;
use Greg\Orm\Driver\DriverInterface;

trait DriverTrait
{
    protected function bootDriverTrait()
    {
        if (!$this->hasDriver()) {
            $this->app()->scope(function (DriverInterface $driver) {
                $this->setDriver($driver);
            });
        }
    }

    /**
     * @return Application
     */
    abstract protected function app();
}
