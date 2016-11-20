<?php

namespace App\Services;

use App\Models\SettingsModel;
use App\Strategies\SettingsStrategy;
use Greg\Cache\CacheManager;

class SettingsService implements SettingsStrategy
{
    protected $cache = null;

    protected $model = null;

    public function __construct(CacheManager $cache, SettingsModel $model)
    {
        $this->cache = $cache;

        $this->model = $model;
    }

    public function getList()
    {
        return $this->cache->fetch('app:settings', function () {
            return $this->model->getList();
        }, 10);
    }
}
