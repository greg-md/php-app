<?php

namespace App\Models;

use App\Orm\Table;

class TranslatesLangModel extends Table
{
    protected $name = 'TranslatesLang';

    public function getListByLang($systemName)
    {
        return $this
            ->where('LangSystemName', $systemName)
            ->selectOnly('TranslateKey', 'Text')
            ->fetchPairs();
    }
}
