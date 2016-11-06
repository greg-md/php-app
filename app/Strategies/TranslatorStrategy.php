<?php

namespace App\Strategies;

interface TranslatorStrategy
{
    public function setDefaults();

    public function setLanguage($name);

    public function saveNewTranslates();
}
