<?php

namespace App\Services;

use App\Models\LanguagesModel;
use Greg\Cache\CacheManager;

class LanguagesService
{
    protected $cache = null;

    protected $model = null;

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
        return $this->cache->fetch('app:languages', function () {
            return $this->model->getActiveItems();
        }, 10);
    }
}
