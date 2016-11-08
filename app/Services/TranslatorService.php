<?php

namespace App\Services;

use App\Models\TranslatesModel;
use App\Strategies\TranslatorStrategy;
use Greg\Cache\CacheManager;
use Greg\Translation\Translator;

class TranslatorService implements TranslatorStrategy
{
    protected $translator = null;

    protected $languages = null;

    protected $cache = null;

    protected $model = null;

    protected $rows = null;

    public function __construct(
        Translator $translator,
        LanguagesService $languages,
        CacheManager $cache,
        TranslatesModel $model)
    {
        $this->translator = $translator;

        $this->languages = $languages;

        $this->cache = $cache;

        $this->model = $model;
    }

    public function setDefaults()
    {
        $rows = $this->rows();

        if ($rows->count()) {
            $languages = $rows->get('SystemName');

            $base = $rows->firstWhere('Base', true);

            if (!$base) {
                $base = $rows->first();
            }

            $this->translator
                ->setLanguages($languages)
                ->setLanguage($base['SystemName'])
                ->setDefaultLanguage($base['SystemName']);
        }
    }

    public function setLanguage($name)
    {
        $language = $this->rows()->firstWhere('SystemName', $name);

        if (!$language) {
            throw new \Exception('Language `' . $name . '` is not found.');
        }

        $this->translator->setLanguage($language['SystemName']);

        if ($locales = $language->locales()) {
            setlocale(LC_ALL, $locales);
        }

        $translates = $this->getTranslates($language['SystemName']);

        $this->translator->setTranslates($translates);

        return $this;
    }

    public function saveNewTranslates()
    {
        if ($translates = $this->translator->getNewTranslates()) {
            $this->addTranslates($this->translator->getLanguage(), $translates);
        }

        return $this;
    }

    protected function getTranslates($language)
    {
        return $this->cache->fetch('app:translates->' . $language, function () use ($language) {
            return $this->model->getListByLang($language);
        }, 10);
    }

    protected function addTranslates($language, array $translates)
    {
        $languagesKeys = $this->rows()->get('SystemName');

        foreach ($translates as $key => $text) {
            $this->model->getDriver()->beginTransaction();

            $row = $this->model->create([
                'Key' => $key,
            ])->save();

            $row->lang()->insertForEach('LangSystemName', $languagesKeys, [
                'Text' => $text,
            ]);

            $this->model->getDriver()->commit();
        }

        $this->cache->delete('app:translates->' . $language);

        return $this;
    }

    protected function rows()
    {
        if ($this->rows === null) {
            $this->rows = $this->languages->getAll();
        }

        return $this->rows;
    }

    public function adapter()
    {
        return $this->translator;
    }
}
