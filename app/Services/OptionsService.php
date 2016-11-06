<?php

namespace App\Services;

use App\Models\OptionsModel;
use App\Strategies\OptionsStrategy;
use Greg\Cache\CacheManager;

class OptionsService implements OptionsStrategy
{
    protected $cache = null;

    protected $model = null;

    public function __construct(CacheManager $cache, OptionsModel $model)
    {
        $this->cache = $cache;

        $this->model = $model;
    }

    public function getActiveList()
    {
        return $this->cache->fetch('app:options', function () {
            return $this->model->getActiveList();
        }, 10);
    }
}
