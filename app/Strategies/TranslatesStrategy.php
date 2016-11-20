<?php

namespace App\Strategies;

interface TranslatesStrategy
{
    public function getTranslates($language);

    public function addTranslates($language, array $translates, $insertLanguages);
}
