<?php

namespace App\Orm;

use App\KernelTrait;

abstract class Table extends \Greg\Orm\Table
{
    use KernelTrait, DriverTrait, TableSchemaTrait;
}
