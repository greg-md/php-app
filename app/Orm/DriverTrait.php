<?php

namespace App\Orm;

use Greg\ApplicationContract;
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
     * @return ApplicationContract
     */
    abstract protected function app();
}
