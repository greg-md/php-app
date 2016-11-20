<?php

namespace App\Services;

use App\Models\TranslatesModel;
use App\Strategies\TranslatesStrategy;
use Greg\Cache\CacheManager;

class TranslatesService implements TranslatesStrategy
{
    protected $cache = null;

    protected $model = null;

    public function __construct(CacheManager $cache, TranslatesModel $model)
    {
        $this->cache = $cache;

        $this->model = $model;
    }

    public function getTranslates($language)
    {
        return $this->cache->fetch('app:translates->' . $language, function () use ($language) {
            return $this->model->getListByLang($language);
        }, 10);
    }

    public function addTranslates($language, array $translates, $insertLanguages)
    {
        foreach ($translates as $key => $text) {
            $this->model->getDriver()->beginTransaction();

            $row = $this->model->create([
                'Key' => $key,
            ])->save();

            $row->lang()->insertForEach('LangSystemName', $insertLanguages, [
                'Text' => $text,
            ]);

            $this->model->getDriver()->commit();
        }

        $this->cache->delete('app:translates->' . $language);

        return $this;
    }
}
