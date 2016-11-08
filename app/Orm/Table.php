<?php

namespace App\Orm;

abstract class Table extends \Greg\Orm\Table
{
    use \AppTrait, DriverTrait, TableSchemaTrait;
}
