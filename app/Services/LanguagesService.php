<?php

namespace App\Services;

use App\Models\LanguagesModel;
use App\Strategies\LanguagesStrategy;
use Greg\Cache\CacheManager;

class LanguagesService implements LanguagesStrategy
{
    private $cache;

    private $model;

    public function __construct(CacheManager $cache, LanguagesModel $model)
    {
        $this->cache = $cache;

        $this->model = $model;
    }

    /**
     * @return LanguagesModel|LanguagesModel[]
     */
    public function getAll()
    {
        return $this->cache->remember('app:languages', function () {
            return $this->model->getActiveItems();
        }, 10);
    }

    /**
     * @param $systemName
     * @return LanguagesModel
     */
    public function get($systemName)
    {
        return $this->getAll()->searchWhere('SystemName', $systemName);
    }
}
