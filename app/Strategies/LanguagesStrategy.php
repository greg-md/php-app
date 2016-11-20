<?php

namespace App\Strategies;

use App\Models\LanguagesModel;

interface LanguagesStrategy
{
    /**
     * @return LanguagesModel|LanguagesModel[]
     */
    public function getAll();

    /**
     * @param $systemName
     * @return LanguagesModel
     */
    public function get($systemName);
}