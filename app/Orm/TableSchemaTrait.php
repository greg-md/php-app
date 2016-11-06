<?php

namespace App\Orm;

use Greg\Application;
use Greg\Cache\CacheManager;
use Greg\Orm\Driver\MysqlInterface;

trait TableSchemaTrait
{
    protected function populateWithInfo(array $info)
    {
        foreach ($info['columns'] as $column) {
            $this->addColumn($column);
        }

        $info['primaryKeys'] && $this->setPrimaryKeys($info['primaryKeys']);

        $info['autoIncrement'] && $this->setAutoIncrement($info['autoIncrement']);

        return $this;
    }

    protected function populateInfo(CacheManager $cache)
    {
        $info = $cache->fetch('app:table->' . $this->fullName(), function () {
            return $this->getDriver()->tableInfo($this->fullName());
        });

        return $this->populateWithInfo($info);
    }

    protected function bootTableSchemaTrait()
    {
        $this->app()->scope(function (CacheManager $cache) {
            $this->populateInfo($cache);
        });
    }

    /**
     * @return MysqlInterface
     */
    abstract public function getDriver();

    /**
     * @return Application
     */
    abstract public function app();
}
